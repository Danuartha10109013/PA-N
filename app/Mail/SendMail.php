<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $body)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->body['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->body['subject'] === 'Pengajuan Reimbursment') {
            $view = 'mail.pengajuan';
        } else if ($this->body['subject'] === 'Pengajuan Disetujui') {
            $view = 'mail.setujui';
        } else {
            $view = 'mail.ditolak';
        }

        return new Content(
            view: $view,
            with: [
                'data' => $this->body['data']
            ]
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
