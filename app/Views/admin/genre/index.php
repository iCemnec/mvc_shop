<?php
\Core\View::render('admin/common/header.php', ['title' => "All Genres"]);
$genres = $args;
?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Genres</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Genres</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>All Genres</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php
                            if (!empty($genres)) {
                                ?>
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    foreach ($genres as $genre) {
                                        ?>
                                        <tr>
                                            <td><?php echo $genre['id']; ?></td>
                                            <td><?php echo $genre['title']; ?></td>
                                            <td>
                                                <a href="/admin/genre/<?php echo $genre['id']; ?>/edit/" class="btn btn-info" role="button">Edit</a>
                                                <a href="/admin/genre/<?php echo $genre['id']; ?>/delete/" class="btn btn-info" role="button">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                ?>
                                <h3>There is no genre yet.</h3>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<?php
\Core\View::render('admin/common/footer.php');
