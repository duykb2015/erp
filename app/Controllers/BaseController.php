<?php

namespace App\Controllers;

use App\Models\Notification;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common', 'notification', 'form', 'uri'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    protected $notifications = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->notifications = static::loadNotification();
    }

    function handleResponse($data = [], $code = 200, $status = 'success')
    {
        $code >= 0   and $status = 'unknown';
        $code >= 200 and $status = 'success';
        $code >= 300 and $status = 'warning';
        $code >= 400 and $status = 'error';

        return $this->respond($data, $code, $status);
    }

    public static function loadNotification()
    {
        $notificationModel = new Notification();
        return $notificationModel->select([
            'notification.id',
            'notification.title',
            'notification.message',
            'notification.created_at',
            'user.photo'
        ])->join('user', 'user.id = notification.sender_id')->where('notification.recipient_id', session()->get('user_id'))
            ->where('notification.is_read', FALSE)
            ->orderBy('id', 'DESC')
            ->find();
    }
}
