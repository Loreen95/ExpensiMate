<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationPreference;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Display the notification preferences settings form
    public function index()
    {
        // Retrieve the user's notification preferences (assuming you have authentication in place)
        $user = auth()->user();
        $notificationPreferences = NotificationPreference::where('user_id', $user->id)->first();

        return view('notification.preferences', compact('notificationPreferences'));
    }


    public function update(Request $request)
    {
        // Temporarily remove or simplify validation
        // $this->validate($request, ...);

        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the user's notification preferences
        $notificationPreferences = $user->notificationPreferences;

        // Update the preferences
        $notificationPreferences->update([
            'frequency' => $request->input('frequency'),
            'advance_notice_days' => $request->input('advance_notice_days'),
            'is_active' => $request->input('is_active') === 'on' ? true : false,
            'notification_time' => $request->input('notification_time'),

            // Other fields...
        ]);

        // Redirect back to the preferences page with a success message
        return redirect()->route('notification.preferences')->with('success', 'Notification preferences updated successfully!');
    }


}
