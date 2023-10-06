<?php

namespace App\Services;

use App\Models\NotificationPreference;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyNotificationMail;
use App\Mail\WeeklyNotificationMail;
use Illuminate\Support\Facades\Log;


class NotificationService
{
    public function scheduleNotifications($user)
    {
        // Retrieve the user's notification preferences
        $notificationPreferences = NotificationPreference::where('user_id', $user->id)->first();

        if ($notificationPreferences) {
            // Check the user's notification frequency and send the corresponding email
            if ($notificationPreferences->frequency === 'daily') {
                // Send the daily notification email
                $this->sendDailyNotification($user);
            } elseif ($notificationPreferences->frequency === 'weekly') {
                // Send the weekly notification email
                $this->sendWeeklyNotification($user);
            }
        }
    }

    public function sendNotifications($user)
    {
        $notificationPreferences = NotificationPreference::where('user_id', $user->id)->first();

        if ($notificationPreferences) {
            if ($notificationPreferences->frequency === 'daily') {
                $this->sendDailyNotification($user);
            } elseif ($notificationPreferences->frequency === 'weekly') {
                $this->sendWeeklyNotification($user);
            }
        }
    }


    private function sendDailyNotification($user)
    {
        // Customize the email content for daily notifications
        $emailContent = 'Here are your daily notifications...';

        // Send the email
        Mail::to($user->email)->send(new DailyNotificationMail($emailContent));
    }

    private function sendWeeklyNotification($user)
    {
        // Customize the email content for weekly notifications
        $emailContent = 'Here are your weekly notifications...';

        // Send the email
        Mail::to($user->email)->send(new WeeklyNotificationMail($emailContent));
    }
}
