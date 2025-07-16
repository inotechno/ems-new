<?php

use App\Models\Notification;

if(!function_exists('createNotification')) {
    function createNotification($user_id, $title, $slug, $type, $description, $url = null) {

        $icon = '';
        $color = '';

        if($type == 'Daily Report') {
            $icon= 'bx bx-report';
            $color = 'success';
        } else if($type == 'Finance Request') {
            $icon = 'bx bx-wallet';
            $color = 'warning';
        } else if($type == 'Absent Request') {
            $icon = 'bx bx-time-five';
            $color = 'warning';
        } else if($type == 'Leave Request') {
            $icon = 'bx bx-time-five';
            $color = 'danger';
        } else {
            $icon = 'bx bxs-time-five';
            $color = 'secondary';
        }

        Notification::create([
            'user_id' => $user_id,
            'title' => $title,
            'slug' => $slug,
            'type' => $type,
            'description' => $description,
            'url' => $url,
            'icon' => $icon,
            'color' => $color
        ]);

        return true;
    }

    function readNotification($notification_id) {
        Notification::where('id', $notification_id)->update([
            'is_read' => true
        ]);
    }
}
