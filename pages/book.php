<div class="container pt-4">
    <div class="row">
        <div class="col-sm-3">
            <div class="d-flex justify-content-center">
                <h3>Tambah Buku</h3>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="ISBN" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="author">Author</label>
                    <input type="text" class="form-control" name="author" id="author" placeholder="Author" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="publisher">Publisher</label>
                    <input type="text" class="form-control" name="publisher" id="publisher" placeholder="Publisher" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="publish_year">Publish Year</label>
                    <input type="number" class="form-control" name="publish_year" id="publish_year" placeholder="Publish Year" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="desc">Description</label>
                    <textarea class="form-control" name="desc" id="desc" rows="5" placeholder="Short Description" required autofocus></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="genre_id">Genre</label>
                    <select class="form-select" aria-label="Default select example" name="genre_id" id="genre_id" required autofocus>
                        <option selected disabled>Choose Genre</option>
                        <?php
                            /** @var  $genre \entity\Genre */
                            foreach ($resultsGenre as $genre) {
                                echo '<option value="' . $genre->getId() . '">' . $genre->getName() . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="txtFiles">Cover</label>
                    <input type="file" class="form-control" name="txtFiles" id="txtFiles" accept="image/*">
                </div>
                <div class="form-group mb-3">
                    <input class="btn btn-dark" style="width: 100%;" type="submit" value="Save Data" name="btnSave">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            <table class="table table-striped" style="text-align: center;">
                <thead class="thead-dark">
                    <tr style="border-bottom: 1px;">
                        <th scope="col">Cover</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Publish&nbsp;Year</th>
                        <th scope="col">Description</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    /** @var $book \entity\Book */
                    foreach ($resultsBook as $book) {
                        $fileName = $book->getCover();
                        $filePath = 'uploads/';
                        $myFile = $filePath . $fileName;
                        echo '<tr>';
                        echo '<td>';
                        if ($book->getCover() != null) {
                            echo '<img width="120" src="' . $myFile . '" alt="">';
                        } else {
                            echo '<img width="120" src="uploads/default.jpg" alt="">';
                        }
                        echo '</td>';
                        echo '<td>' . $book->getIsbn() . '</td>';
                        echo '<td>' . $book->getTitle() . '</td>';
                        echo '<td>' . $book->getAuthor() . '</td>';
                        echo '<td>' . $book->getPublisher() . '</td>';
                        echo '<td>' . $book->getYear() . '</td>';
                        echo '<td>' . $book->getDescription() . '</td>';
                        echo '<td>' . $book->getGenre()->getName() . '</td>';
                        echo '<td>
                            <div class="justify-content-center">
                                <button class="btn btn-warning mb-2" onclick="editBook(' . $book->getIsbn() . ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            </div>
                            <div class="justify-content-center">
                                <button class="btn btn-success mb-2" onclick="uploadImageBook(' . $book->getIsbn() .')"><i class="fa fa-upload" aria-hidden="true"></i></button>
                            </div>
                            <div class="justify-content-center">
                                <button class="btn btn-danger" onclick="deleteBook(' . $book->getIsbn() . ')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </td>';
                        echo '</tr>';
                        }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="js/book_index.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>