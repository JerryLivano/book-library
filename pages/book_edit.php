<div class="container ps-5 pe-5">
    <form method="post" enctype="multipart/form-data">
        <div class="form-row d-flex justify-content-center mb-3">
            <div class="form-group col-md-6 pe-2">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="isbn" value="<?php echo $book->getIsbn(); ?>" disabled>
            </div>
            <div class="form-group col-md-6 ps-2">
                <label for="judul">Title</label>
                <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $book->getTitle(); ?>">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="author">Author</label>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo $book->getAuthor(); ?>">
        </div>
        <div class="form-row d-flex justify-content-center mb-3">
            <div class="form-group col-md-8 pe-2">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="publisher" value="<?php echo $book->getPublisher(); ?>">
            </div>
            <div class="form-group col-md-4 ps-2">
                <label for="publish_year">Publish Year</label>
                <input type="number" class="form-control" name="publish_year" id="publish_year" value="<?php echo $book->getYear(); ?>">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="desc">Description</label>
            <textarea class="form-control" rows="5" name="desc" id="desc">
                <?php echo $book->getDescription(); ?>
            </textarea>
        </div>
        <div class="form-group mb-3">
            <label for="cover"><h3>Current Cover</h3></label> <br>
            <?php
            if ($book->getCover() != null){
                echo '<img class="mb-4" src="uploads/' . $book->getCover() . '" alt=" " width="100px">';
            } else {
                echo '<img class="mb-4" src="uploads/default.jpg" alt=" " width="100px">';
            }
            ?>
            <div>New Cover</div>
            <input type="file" class="form-control my-3" name="txtFile" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="genre_id">Genre</label>
            <select class="form-select" aria-label="Default select example" name="genre_id" id="genre_id">
                <option disabled selected>-- Select One --</option>
<!--                <option value="--><?php //echo $book->getGenre()->getId(); ?><!--" selected>--><?php //echo $book->getGenre()->getName(); ?><!--</option>-->
                <?php
                /** @var  $genre \entity\Genre */
                foreach ($results as $genre) {
                    echo '<option value="' . $genre->getId() . '">' . $genre->getName() . '</option>';
                }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-dark mb-3" value="Update Data" name="btnUpdate" />
    </form>
</div>
