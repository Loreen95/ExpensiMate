<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
}
