<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $student;
    public $validatedBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
        $this->student = $ticket->user;
        $this->validatedBy = $ticket->validatedBy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.ticket_rejected');
    }
}
