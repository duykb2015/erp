<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Notification as ModelsNotification;

class Notification extends BaseController
{
    public function markAsRead()
    {
        $id = $this->request->getPost('id');
        $notificationModel = new ModelsNotification();

        $notificationModel->update($id, ['is_read' => TRUE]);
        
        return TRUE;
    }

    public function markAllAsRead()
    {
        $ids = $this->request->getPost('ids');
        $notificationModel = new ModelsNotification();

        $notificationModel->update($ids, ['is_read' => TRUE]);
        
        return TRUE;
    }
}
