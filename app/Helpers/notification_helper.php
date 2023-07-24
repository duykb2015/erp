
<?php

class Notification
{
    public static function assignedTask(string $sender, string $project, string $task, int $notification)
    {
        $link = base_url("project/{$project}/task/{$task}");
        return "<b>{$sender}</b> đã giao cho bạn một công việc!
        <input type='hidden' id='notification-link-{$notification}' value='{$link}'>
        </br><a onclick='markAsRead({$notification})'>Bấm vào đây để xem!</a>";
    }

    public static function assignedTaskReporter(string $sender, string $project, string $task, int $notification)
    {
        $link = base_url("project/{$project}/task/{$task}");
        return "<b>{$sender}</b> đã giao cho bạn làm người báo cáo công việc!
        <input type='hidden' id='notification-link-{$notification}' value='{$link}'>
        </br><a onclick='markAsRead({$notification})'>Bấm vào đây để xem!</a>";
    }

    public static function reviewRequest(string $sender, string $project, string $task, int $notification)
    {
        $link = base_url("project/{$project}/task/{$task}");
        return "<b>{$sender}</b> đã hoàn thành công việc và đang chờ bạn xem xét!
        <input type='hidden' id='notification-link-{$notification}' value='{$link}'>
        </br><a onclick='markAsRead({$notification})'>Bấm vào đây để xem!</a>";
    }

    public static function taskDone(string $sender, string $project, string $task, int $notification)
    {
        $link = base_url("project/{$project}/task/{$task}");
        return "<b>{$sender}</b> đã phê duyệt công việc của bạn là hoàn thành!
        <input type='hidden' id='notification-link-{$notification}' value='{$link}'>
        </br><a onclick='markAsRead({$notification})'>Bấm vào đây để xem!</a>";
    }

    public static function inviteRequest(string $sender, string $project)
    {
        $link = base_url("project/{$project}/invite");
        return "<b>{$sender}</b> mời bạn tham gia dự án! </br><a href='$link'>Bấm vào đây chấp thuận hoặc tự chối!</a>";
    }

    // public static function inviteRequestRefuse(string $sender)
    // {
    //     return "<b>{$sender}</b> đã từ chối tham gia dự án!";
    // }
}
