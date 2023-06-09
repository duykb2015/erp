<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

define('WRONG_LOGIN_INFORMATION_MESSAGE', 'Tài khoản hoặc mật khẩu sai, vui lòng kiểm tra lại!');
define('PASSWORD_NOT_MATCH', 'Tài khoản hoặc mật khẩu sai, vui lòng kiểm tra lại!');

define('UPLOAD_PATH', FCPATH . 'imgs/');

define('LOWEST', 'lowest');
define('LOW', 'low');
define('NORMAL', 'normal');
define('HIGH', 'high');
define('HIGHEST', 'highest');

define('TASK_PRIORITY', [
    LOWEST => 'Rất thấp',
    LOW => 'Thấp',
    NORMAL => 'Bình thường',
    HIGH => 'Cao',
    HIGHEST => 'Rất cao',
]);

define('CUSTOM', 0);
define('INIT', 1);
define('INPROGRESS', 2);
define('DONE', 3);

define('BASE_SECTION', [
    CUSTOM     => ['background' => '#e9f2ff', 'color' => '#0055cc'],
    INIT       => ['background' => '#e9eaee', 'color' => '#44546f'],
    INPROGRESS => ['background' => '#e9f2ff', 'color' => '#0055cc'],
    DONE       => ['background' => '#dffcf0', 'color' => '#216e4e'],
]);

define('LEADER', 'leader');
define('MEMBER', 'member');
define('OWNER', 'owner');
define('PROJECT_ROLE', [
    OWNER => 'Chủ sở hữu',
    LEADER => 'Trưởng nhóm',
    MEMBER => 'Thành viên'
]);

define('SYSTEM_COMMENT_TYPE', 'system');
define('USER_COMMENT_TYPE', 'comment');

define('INITIALIZE', 'initialize');
define('ACTIVE', 'active');
define('CLOSE', 'close');
define('DELETED', 'deleted');

define('PROJECT_STATUS', [
    INITIALIZE => 'Khởi tạo',
    ACTIVE => 'Đang hoạt động',
    CLOSE => 'Đóng',
    DELETED => 'Đã xoá'
]);

define('ADMIN', 'admin');
define('MODERATOR', 'moderator');
define('USER', 'user');

define('USER_TYPE', [
    ADMIN => 'Admin',
    MODERATOR => 'Quản trị viên',
    USER => 'Người dùng'
]);
