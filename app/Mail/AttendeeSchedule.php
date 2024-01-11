<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SchedulerController;

class AttendeeSchedule extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $events;

    /**
     * Create a new message instance.
     */
    public function __construct() {

        // get the event list for the schedule
        $_sched = new SchedulerController();
        $this->events = $_sched->get_schedule(Auth::user());
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@alaska.edu', 'SRDD Mailer Daemon'),
            subject: 'Attendee Schedule',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.sched',
            text: 'emails.sched-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
