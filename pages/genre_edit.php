<div class="container pt-4 ps-5 pe-5">
    <form method="post">
        <div class="form-row d-flex justify-content-center">
            <div class="form-group col-md-6 pe-2">
                <label for="txtId">Genre ID</label>
                <input type="text" class="form-control" name="txtId" id="txtId" value="<?php echo($genre->getId()); ?>" disabled>
            </div>
            <div class="form-group col-md-6 ps-2">
                <label for="txtName">Genre Name</label>
                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($genre->getName()); ?>">
            </div>
        </div>
        <input type="submit" class="btn btn-dark mt-3" value="Update" name="btnUpdate"></input>
    </form>
