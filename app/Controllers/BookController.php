<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Core\Controller;
use Core\View;

class BookController extends Controller
{
    protected $book;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->book = new Book;
    }

    public function index()
    {
        $books = $this->book->showAll();

        $genre = new Genre();
        $genres = $genre->showAll();

        View::render('books/index.php', [$books, $genres]);
    }

    public function showGenre(array $data)
    {
        $books = $this->book->showByGenre($data);
        if (!empty($books)) {
            View::render('books/genre.php', $books);
        } else {
            View::render('books/genre.php');
        }
    }

}