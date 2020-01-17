<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Core\Controller;
use Core\View;

class BookController extends Controller
{
    protected $book;
    protected $genre;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->book = new Book;
        $this->genre = new Genre();
    }

    public function index()
    {
        $books = $this->book->showAll();

        $genres = $this->genre->showAll();

        if (!empty($books)) {
            View::render('books/index.php', [$genres, $books]);
        } else {
            View::render('books/index.php', [$genres]);
        }
    }

    public function show(array $data)
    {
        $book = $this->book->show($data);

        $genres = $this->genre->showGenresByBookId($data);

        View::render('books/book.php', [$book, $genres]);
    }

}