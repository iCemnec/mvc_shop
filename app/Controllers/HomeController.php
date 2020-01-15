<?php


namespace App\Controllers;

use Core\Controller;
use App\Models\Book;
use Core\View;
use Exception;

class HomeController extends Controller
{
    public function index()
    {
        $book = new Book();
        $booksNew = $book->showNew();

        if (!empty($booksNew)) {
            View::render('common/main.php', $booksNew);
        } else {
            View::render('common/main.php');
        }

    }
}