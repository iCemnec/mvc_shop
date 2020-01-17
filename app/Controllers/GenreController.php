<?php


namespace App\Controllers;


use App\Models\Book;
use App\Models\Genre;
use Core\Controller;
use Core\View;

class GenreController extends Controller
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
        $currentGenre = $this->genre->show($data);

        $books = $this->book->showBooksByGenreId($data);
        if (!empty($books)) {
            View::render('books/genre.php', [$genres, $currentGenre, $books]);
        } else {
            View::render('books/genre.php', [$genres, $currentGenre]);
        }
    }

}