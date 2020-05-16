<?php

namespace App\Mail;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $student;
    public $validatedBy;
    public $ticketUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $ticketUrl = '')
    {
        $this->ticket = $ticket;
        $this->student = $ticket->user;
        $this->validatedBy = $ticket->validatedBy;
        $this->ticketUrl = $ticketUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.ticket_generated');
//                    ->attach($this->ticketUrl);
    }
}
