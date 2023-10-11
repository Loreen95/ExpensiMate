<?php

namespace App\Services;

use App\Models\NotificationPreference;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Log;


class NotificationService
{
    public function scheduleNotifications($user)
    {
        $this->sendNotifications($user);
    }

    public function sendNotifications($user)
    {
        $notificationPreferences = NotificationPreference::where('user_id', $user->id)->first();

        if ($notificationPreferences) {
            $frequency = $notificationPreferences->frequency;
            $emailContent = $this->getEmailContent($frequency);
            $upcomingExpenses = $this->getUpcomingExpenses($user);

            if ($emailContent && $upcomingExpenses) {
                $this->sendNotificationEmail($user, $emailContent, $frequency, $upcomingExpenses);
            }
        }
    }

    private function getEmailContent($frequency)
    {
        if ($frequency === 'daily') {
            return 'Here are your daily notifications...';
        } elseif ($frequency === 'weekly') {
            return 'Here are your weekly notifications...';
        }

        return null; // Handle other cases as needed
    }

    private function getUpcomingExpenses($user)
    {
        // Retrieve and return the upcoming expenses for the user
        // You will need to implement the logic to fetch the expenses
        // and format them as needed.
        return null;
    }

    private function sendNotificationEmail($user, $emailContent, $frequency, $upcomingExpenses)
    {
        Mail::to($user->email)->send(new NotificationMail($emailContent, $frequency, $upcomingExpenses));
    }

}
