<?php


namespace App\Controllers;


use App\Models\Book;
use App\Models\Genre;
use Core\Controller;
use Core\View;

class AuthorController extends Controller
{
    protected $book;
    protected $genre;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->book = new Book;
        $this->genre = new Genre();
    }

    public function show(array $data)
    {
        $genres = $this->genre->showAll();
        $currentAuthor = $this->genre->show($data);

        $books = $this->book->showBooksByAuthorId($data);
        if (!empty($books)) {
            View::render('books/author.php', [$genres, $currentAuthor, $books]);
        } else {
            View::render('books/author.php', [$genres, $currentAuthor]);
        }
    }

}