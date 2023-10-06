<?php
    namespace App\Mail;

    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    
    class WeeklyNotificationMail extends Mailable
    {
        use SerializesModels;
    
        public $emailContent;
    
        public function __construct($emailContent)
        {
            $this->emailContent = $emailContent;
        }
    
        public function build()
        {
            return $this->view('emails.weekly_notification')
                ->subject('Weekly Notifications');
        }
    }