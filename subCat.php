<?php
define('title', 'Add Sub Category');
include 'header.php';
$cat = mysqli_query($conn, "SELECT * FROM categories");
$sub_cat = mysqli_query($conn, "SELECT * FROM sub_categories");
   
if(isset($_POST['subCat'])){
    $subCatName = $_POST['subCatName'];
    $cat_id = implode(',', $_POST['category']);
    $file = $_FILES['image'];
    $filename = $file['name'];
    $filepath = $file['tmp_name'];
    $image = 'categories/'.$filename;
    move_uploaded_file($filepath, $image);
    $description = $_POST['description'];
    $addCat =  mysqli_query($conn, "INSERT INTO sub_categories (cat_id, name, image, description) VALUES('$cat_id', '$subCatName', '$image', '$description')");
    header('Location:subCat.php');
}
?>
 <div class="container">
    <h2>Sub Categories</h2>
    <strong>Add Sub categories</strong>
    <form class="form-group" action="" method="post" enctype="multipart/form-data">
    <label> Enter Sub Category Name</label>
        <input class="form-control" type="text" name="subCatName" required><br><br>
    <label>Choose Categories:</label>
    <div class="form-check form-check-inline"> 
        <?php while($row = mysqli_fetch_array($cat)): ?>
        <div class="form-check form-check-inline"> 
            <input class="form-check-input" type="checkbox" name="category[]" id="" value="<?php echo $row['id'] ?>" >
            <label class="form-check-label" ><?php echo $row['name']; ?></label>
        </div>
        <?php endwhile; ?>
    </div>
       <br><br>
        <label>Category Image</label>
        <input type="file" name="image" required><br><br>
        <label>Category Description</label>
        <textarea name="description" id="" cols="30" rows="10" required></textarea><br>
        <input type="submit" name="subCat" class=" btn btn-primary" value="Add Sub-Category">
</div>