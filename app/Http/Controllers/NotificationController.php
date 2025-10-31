<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id = null)
    {
        $user = Auth::user();
        try {
            if ($id) {
                $notification = $user->notifications()->find($id);
                if ($notification && $notification->read_at === null) {
                    $notification->markAsRead();
                    return response()->json(['success' => true]);
                }
            } else {
                $user->unreadNotifications->markAsRead();
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


     public function destroy($id = null)
    {
        $user = Auth::user();
        try {
            if ($id) {
                $notification = $user->notifications()->find($id);
                if ($notification) {
                    $notification->delete();
                    return response()->json(['success' => true]);
                }
            } else {
                $user->notifications()->delete();
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
