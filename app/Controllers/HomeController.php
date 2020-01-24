<?php


namespace App\Controllers;

use Core\Controller;
use App\Models\Book;
use Core\View;
use Exception;

class HomeController extends Controller
{
    protected $book;

    public function index()
    {
        $this->book = new Book();
        $booksNew = $this->book->showNew();

        if (!empty($booksNew)) {
            View::render('common/main.php', $booksNew);
        } else {
            View::render('common/main.php');
        }

    }
}