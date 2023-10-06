<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailContent;
    public $frequency;
    public $upcomingExpenses;
    
    /**
     * Create a new message instance.
     *
     * @param  string  $emailContent
     * @param  string  $frequency
     * @param  string  $upcomingExpenses
     * @return void
     */
    public function __construct($emailContent, $frequency, $upcomingExpenses)
    {
        $this->emailContent = $emailContent;
        $this->frequency = $frequency;
        $this->upcomingExpenses = $upcomingExpenses;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // You can customize the email subject and view here
        return $this->subject($this->frequency === 'daily' ? 'Daily Notifications' : 'Weekly Notifications')
                    ->view('notification.emails.notification'); // Create a corresponding email blade view
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notification\emails\notification',
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
