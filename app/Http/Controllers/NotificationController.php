<?php

namespace App\Http\Controllers;

use App\Models\NotifM;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Method to mark all notifications as read
    public function markAsRead(Request $request)
{
    $ids = $request->input('ids');

    // Mark notifications as read
    $notifications = \App\Models\NotifM::whereIn('id', $ids)->update(['status' => 1]);

    return response()->json(['success' => true]);
}

}
