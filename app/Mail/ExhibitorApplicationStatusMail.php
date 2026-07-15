<?php

namespace App\Mail;

use App\Models\ExhibitorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExhibitorApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public ExhibitorApplication $application;
    public string $statusMessage;

    public function __construct(ExhibitorApplication $application, string $statusMessage)
    {
        $this->application = $application;
        $this->statusMessage = $statusMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Exhibitor Application Status Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.exhibitor-status',
            with: [
                'userName'      => $this->application->user->first_name,
                'statusMessage' => $this->statusMessage,
            ],
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
