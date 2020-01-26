<?php


namespace App\Controllers;


use App\Components\Auth;
use App\Components\ErrorHandler;
use App\Models\User;
use Core\Controller;
use Core\View;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class UserController extends Controller
{
    protected $user;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->user = new User();
    }

    public function store()
    {
        try {
            if (isset($_POST)) {
                $data = [];
                $data['first_name'] = htmlspecialchars(trim($_POST['username']));
                $data['email'] = htmlspecialchars(trim($_POST['email']));
                $data['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
                $data['auth_token'] = sha1(random_bytes(99)) . sha1(random_bytes(99));
                $data['role_id'] = isset($_POST['role_id']) ? htmlspecialchars(trim($_POST['role_id'])) : '3';

                if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

                    if ($this->user->getColumnByValue('email', $data['email'])) {
                        $this->validation = false;
                    }

                    if ($this->validation) {
                        $userId = $this->user->create($data);

                        Auth::set('username', $data['first_name']);
                        Auth::set('auth_token', $data['auth_token']);
                        Auth::set('is_auth', true);
                        Auth::set('user_id', $userId);

                        $result = [
                            'status' => 'success',
                            'id' => "$userId"
                            ];
                    } else {
                        $result = ['status' => 'error'];
                    }
                    echo json_encode($result);
                }
            } else {
                throw new Exception('Empty the POST array.');
            }
        } catch (Exception $e) {
            $log = new Logger('UserController');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    public function login()
    {
        try {
            if (isset($_POST)) {
                $email = htmlspecialchars(trim($_POST['email']));
                $password = trim($_POST['password']);

                $this->user = User::checkUserData($email, $password);
                $userId = $this->user['id'];

                if ($this->user) {
                    Auth::set('is_auth', true);
                    Auth::set('user_id', $userId);
                    Auth::set('username', $this->user['first_name']);
                    Auth::set('auth_token', $this->user['auth_token']);

                    if (Auth::checkAdmin()) {
                        $result = [
                            'status' => 'admin',
                            'id' => "$userId"
                        ];
                    } else {
                        $result = [
                            'status' => 'success',
                            'id' => "$userId"
                        ];
                    }
                } else {
                    $result = ['status' => 'error'];
                }

                echo json_encode($result);
            } else {
                throw new Exception('Empty the POST array.');
            }
        } catch (Exception $e) {
            $log = new Logger('UserController');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    public function show(array $data)
    {
        $user = $this->user->show($data);
        View::render('account/index.php', $user);
    }

    public function edit(array $data)
    {
        $user = $this->user->show($data);
        View::render('account/edit.php', $user);
    }

    public function update(array $data)
    {
        try {
            if (isset($_POST)) {

                $userId = trim($_POST['userId']);
                $password = trim($_POST['password']);

                $checkPass = $this->user->checkUserPassword($userId, $password);

                if ($checkPass) {
                    $data = [];
                    $data['id'] = htmlspecialchars(trim($_POST['userId']));
                    $data['first_name'] = htmlspecialchars(trim($_POST['firstName']));
                    $data['last_name'] = htmlspecialchars(trim($_POST['lastName']));
                    $data['email'] = htmlspecialchars(trim($_POST['email']));
                    $data['phone'] = htmlspecialchars(trim($_POST['phone']));
                    $data['role_id'] = isset($_POST['role_id']) ? htmlspecialchars(trim($_POST['role_id'])) : '3';

                    $firstName = $data['first_name'];

                    $changeUser = $this->user->update($data);

                    if ($changeUser) {
                        $result = [
                            'status' => 'success',
                            'id' => "$userId",
                            'first_name' => "$firstName"
                        ];
                    } else {
                        $result = ['status' => 'errorUpdate'];
                    }

                } else {
                    $result = ['status' => 'wrongPassword'];
                }

            } else {
                $result = ['status' => 'error'];
            }

            echo json_encode($result);

        } catch (Exception $e) {
            $log = new Logger('UserController');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    public function logout()
    {
        try {
            if (Auth::isAuth()) {
                Auth::sessionDelete();
                header('HTTP/1.1 200 OK');
                header("Location: " . SITE_URL);
                return true;
            }
            return false;
        } catch (Exception $e) {
            $log = new Logger('UserController');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
            return false;
        }
    }

}