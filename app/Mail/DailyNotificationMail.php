<?php
    // DailyNotificationMail.php
    namespace App\Mail;

    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class DailyNotificationMail extends Mailable
    {
        use SerializesModels;

        public $emailContent;

        public function __construct($emailContent)
        {
            $this->emailContent = $emailContent;
        }

        public function build()
        {
            return $this->view('emails.daily_notification')
                ->subject('Daily Notifications');
        }
    }
