<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\TicketDestroyRequest;
use App\Http\Requests\Ticket\TicketIndexRequest;
use App\Http\Requests\Ticket\TicketPdfRequest;
use App\Http\Requests\Ticket\TicketRejectRequest;
use App\Http\Requests\Ticket\TicketStoreRequest;
use App\Http\Requests\Ticket\TicketValidateRequest;
use App\Institute;
use App\Mail\TicketGenerated;
use App\Mail\TicketRejected;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class TicketController extends Controller
{

    public function index(TicketIndexRequest $request) {
        if (Auth::user()->is_student) {
            $tickets = Ticket::where('user_id', Auth::user()->id)
                ->orderBy('validated_at', 'desc')
                ->paginate(13);
            return $this->response200($tickets);
        }
        $tickets = Ticket::with(['user', 'student'])
            ->orderBy('is_validated')
            ->orderBy('created_at', 'desc')
            ->paginate(13);
        return $this->response200($tickets);
    }

    public function store(TicketStoreRequest $request) {
        $data = $request->only(['reason']);
        $data['user_id'] = Auth::user()->id;
        $ticket = Ticket::create($data);

        return $this->response200($ticket);
    }

    public function destroy(TicketDestroyRequest $request, int $id) {
        $ticket = Ticket::find($id);

        if ($ticket->is_validated) {
            return $this->response403();
        }

        $result = $ticket->delete();

        if (!$result) {
            return $this->response422(['Error']);
        }

        return $this->response200(['Success']);
    }

    public function validateTicket(TicketValidateRequest $request, int $id) {
        $data = $request->only(['registration_number', 'ticket_type']);
        $ticket = Ticket::with(['validatedBy.staff', 'user.student'])->find($id);
        if ($ticket->is_validated) {
            return $this->response403();
        }

        $ticket->registration_number = $data['registration_number'];
        $ticket->ticket_type = $data['ticket_type'];
        $ticket->validated_by = Auth::user()->id;
        $ticket->validated_at = Carbon::now();
        $ticket->is_validated = true;

        $result = $ticket->save();

        $ticket = Ticket::with(['validatedBy.staff', 'user.student.scholarships'])->find($id);

//        $storageUrl = $this->generateTicketPDFForEmail($ticket);
//        Mail::to($ticket->user->email)->send(new TicketGenerated($ticket, $storageUrl));

        Mail::to($ticket->user->email)->send(new TicketGenerated($ticket));

        if ($result) {
            return $this->response200(['Success']);
        }

        return $this->response422([]);
    }

    public function rejectTicket(TicketRejectRequest $request, int $id) {
        $data = $request->only(['rejection_reason']);
        $ticket = Ticket::with(['validatedBy.staff', 'user.student'])->find($id);
        if ($ticket->is_validated) {
            return $this->response403();
        }

        $ticket->rejection_reason = $data['rejection_reason'];
        $ticket->validated_by = Auth::user()->id;
        $ticket->validated_at = Carbon::now();
        $ticket->is_validated = true;

        $result = $ticket->save();

        $ticket = Ticket::with(['validatedBy.staff', 'user.student'])->find($id);

        Mail::to($ticket->user->email)->send(new TicketRejected($ticket));

        if ($result) {
            return $this->response200(['Success']);
        }

        return $this->response422([]);
    }

    public function downloadTicketPDF(TicketPdfRequest $request, int $id) {
        $ticket = Ticket::with(['user.student.scholarships'])->find($id);

        if (!$ticket->is_validated) {
            return $this->response403();
        }

        $institute = Institute::find(1)->first();
        $now = Carbon::now();
//        $now = $now->subDays(150);
//        $now = $now->addYear();
        $startDate = Carbon::parse($institute->start_date);
        $midDate = Carbon::parse($institute->mid_date);
        $endDate = Carbon::parse($institute->end_date);

        if ($now->greaterThan($endDate)) {
            return $this->response403();
        }

        $isFirstSemester = true;
        $activeYear = $startDate->year . '/' . $endDate->year;
        if ($now->greaterThanOrEqualTo($midDate)) {
            $isFirstSemester = false;
        }
        $viewName = 'pdf.' . $ticket->ticket_type;
        $pdf = PDF::loadView($viewName, [
            'ticket' => $ticket,
            'user' => $ticket->user,
            'student' => $ticket->user->student,
            'institute' => $institute,
            'isFirstSemester' => $isFirstSemester,
            'activeYear' => $activeYear
        ]);
        $name = 'Ticket' . $now->timestamp . '.pdf';

        return $pdf->download($name);
    }

    public function generateTicketPDFForEmail($ticket) {
        $institute = Institute::find(1)->first();
        $viewName = 'pdf.' . $ticket->ticket_type;
        $pdf = PDF::loadView($viewName, [
            'ticket' => $ticket,
            'user' => $ticket->user,
            'student' => $ticket->user->student,
            'institute' => $institute
        ]);
        $name = 'Ticket' . Carbon::now()->timestamp . '.pdf';

        $storageUrl = 'pdfs/' . $name;

        Storage::put($storageUrl, $pdf->output());

        return Storage::url($name);
    }
}
