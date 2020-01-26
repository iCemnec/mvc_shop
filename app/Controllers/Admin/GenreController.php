<?php


namespace App\Controllers\Admin;


use App\Components\ErrorHandler;
use App\Models\Book;
use App\Models\Genre;
use Core\Controller;
use Core\View;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class GenreController extends Controller
{
    protected $genre;
    protected $book;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->genre = new Genre();
        $this->book = new Book();
    }

    public function index()
    {
        $genres = $this->genre->showAll();
        View::render('admin/genre/index.php', $genres);
    }

    public function edit(array $data)
    {
        $genre = $this->genre->show($data);
        View::render('admin/genre/edit.php', $genre);
    }

    public function update(array $data)
    {
        try {
            if (isset($_POST)) {
                $data['user_id'] = htmlspecialchars(trim($_POST['userId']));
                $data['id'] = htmlspecialchars(trim($_POST['genreId']));
                $data['title'] = htmlspecialchars(trim($_POST['genreTitle']));

                $updated = $this->genre->update($data);

                if ($updated) {
                    $result = ['status' => 'success'];
                } else {
                    $result = ['status' => 'error'];
                }
            } else {
                $result = ['status' => 'error'];
            }
            echo json_encode($result);
        } catch (Exception $e) {
            $log = new Logger('GenreController');
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

    public function create()
    {
        View::render('admin/genre/create.php');
    }

    public function store()
    {
        try {
            if (isset($_POST)) {
                $data['title'] = htmlspecialchars(trim($_POST['genreTitle']));
                $data['user_id'] = htmlspecialchars(trim($_POST['userId']));

                $genreId = $this->genre->create($data);

                if ($genreId) {
                    $result = [
                        'status' => 'success',
                        'id' => "$genreId"
                    ];
                } else {
                    $result = ['status' => 'error'];
                }
                echo json_encode($result);
            } else {
                throw new Exception('Empty the POST array.');
            }
        } catch (Exception $e) {
            $log = new Logger('GenreController');
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

    public function delete(array $data)
    {
        $genre = $this->genre->show($data);
        View::render('admin/genre/delete.php', $genre);
    }

    public function destroy(array $data)
    {
        try {
            if (isset($_POST)) {
                $data['user_id'] = htmlspecialchars(trim($_POST['userId']));
                $data['id'] = htmlspecialchars(trim($_POST['genreId']));
                $data['title'] = htmlspecialchars(trim($_POST['genreTitle']));

                $books = $this->book->showBooksByGenreId($data);

                if ($books) {
                    $result = ['status' => 'error'];
                } else {
                    $this->genre->delete($data['id']);
                    $result = ['status' => 'success'];
                }
            } else {
                $result = ['status' => 'error'];
            }
            echo json_encode($result);
        } catch (Exception $e) {
            $log = new Logger('GenreController');
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

}