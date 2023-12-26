<div class="container pt-4">
    <div class="d-flex justify-content-center">
        <form method="post" action="">
            <label for="txtName">Add Genre</label>
            <input type="text" maxlength="45" name="txtName" id="txtName" placeholder="Genre Name" required autofocus>
            <input type="submit" value="Save Data" name="btnSave">
        </form>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <table class="table table-striped" style="width: 70%; text-align: center;">
            <thead class="thead-dark">
                <tr style="border-bottom: 1px;">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /** @var  $genre \entity\Genre */
                foreach ($results as $genre) {
                    echo '<tr>';
                    echo '<th scope = "row">' . $genre->getId() . '</th>';
                    echo '<td>' . $genre->getName() . '</td>';
                    echo '<td>
                        <button class="btn btn-warning" onclick="editGenre(' . $genre->getId() . ')">Update</button>
                        <button class="btn btn-danger" onclick="deleteGenre(' . $genre->getId() . ')">Delete</button>
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="js/genre_index.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>