<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function show()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('admin.notifications.notifications', compact('notifications'));
    }

    public function read(Notification $notification)
    {
        $notification->update([
            'is_read' => true,
        ]);
    
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('admin.notifications.notifications', compact('notifications'));
    }

    public function destroy(Notification $notification) {
        $notification->delete();
        return redirect(route('notification.show'))->with('success', 'Notification Deleted Successfully');
    }

    public function markAsRead(Notification $notification)
    {
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

}
