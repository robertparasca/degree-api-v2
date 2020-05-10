<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\TicketDestroyRequest;
use App\Http\Requests\Ticket\TicketIndexRequest;
use App\Http\Requests\Ticket\TicketRejectRequest;
use App\Http\Requests\Ticket\TicketStoreRequest;
use App\Http\Requests\Ticket\TicketValidateRequest;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(TicketIndexRequest $request) {
        if (Auth::user()->is_student) {
            $tickets = Ticket::where('user_id', Auth::user()->id)
                ->orderBy('validated_at', 'desc')
                ->paginate(5);
            return $this->response200($tickets);
        }
        $tickets = Ticket::with(['user', 'student'])
            ->orderBy('is_validated')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
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
        $data = $request->only(['registration_number']);
        $ticket = Ticket::find($id);
        if ($ticket->is_validated) {
            return $this->response403();
        }

        $ticket->registration_number = $data['registration_number'];
        $ticket->validated_by = Auth::user()->id;
        $ticket->validated_at = Carbon::now();
        $ticket->is_validated = true;

        $result = $ticket->save();

        if ($result) {
            return $this->response200(['Success']);
        }

        return $this->response422([]);
    }

    public function rejectTicket(TicketRejectRequest $request, int $id) {
        $data = $request->only(['rejection_reason']);
        $ticket = Ticket::find($id);
        if ($ticket->is_validated) {
            return $this->response403();
        }

        $ticket->rejection_reason = $data['rejection_reason'];
        $ticket->validated_by = Auth::user()->id;
        $ticket->validated_at = Carbon::now();
        $ticket->is_validated = true;

        $result = $ticket->save();

        if ($result) {
            return $this->response200(['Success']);
        }

        return $this->response422([]);
    }
}
