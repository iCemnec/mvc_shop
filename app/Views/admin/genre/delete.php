<?php
$title = $args['title'];
\Core\View::render('admin/common/header.php', ['title' => "Delete Genre: $title"]);
$genre = $args;
?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Delete Genre: <?php echo $title; ?></h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Genre</li>
                </ol>

                <form class="cd-form" method="post" name="genreFormDelete">
                    <input id="genre-delete-id" type="hidden" value="<?php echo $genre['id']; ?>">
                    <input id="genre-delete-user-id" type="hidden" value="<?php echo \App\Components\Auth::get('user_id'); ?>">
                    <div class="form-group fieldset">
                        <label for="genre-delete-title">Genre title</label>
                        <input type="text" class="form-control full-width has-border col-lg-3"
                               id="genre-delete-title" value="<?php echo $genre['title']; ?>" readonly>
                        <span class="cd-error-message">There are books in this genre!</span>
                    </div>
                    <div class="form__btn">
                        <a href="/admin/genre/" class="btn btn-info" role="button">Show All</a>
                        <input id="genre-delete" class="btn btn-primary" type="submit" value="Delete">
                    </div>
                </form>
            </div>

        </main>
    </div>


<?php
\Core\View::render('admin/common/footer.php');
