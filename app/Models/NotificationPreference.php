<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;
    
    protected $table = 'notification_preferences';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        protected $fillable = [
        'user_id', // Assuming you have this foreign key in your table
        'frequency',
        'advance_notice_days',
        'is_active',
        'notification_time',
    ];
    
    // Validation rules for fields (optional)
    public static $rules = [
        'user_id' => 'required|integer',
        'frequency' => 'required|in:daily,weekly,bi-weekly,monthly', // Customize this based on your frequency options
        'advance_notice_days' => 'required|integer|min:0', // Ensure it's a non-negative integer
        'is_active' => 'boolean', // Indicates if user is active for notifications
        'notification_time' => 'required|date_format:H:i', // Customize to match your time format
        // Add validation rules for other fields
    ];

}
