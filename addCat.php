<?php
define('title', 'Add Category');
include 'header.php';
$cat = mysqli_query($conn, "SELECT * FROM categories");
$sub_cat = mysqli_query($conn, "SELECT * FROM sub_categories");
if(isset($_POST['cat'])){
    // print_r($_POST); exit;
    $catName = $_POST['category'];
    $file = $_FILES['image'];
    $filename = $file['name'];
    $filepath = $file['tmp_name'];
    $image = 'categories/'.$filename;
    move_uploaded_file($filepath, $image);
    $description = $_POST['description'];
    $parent_cat = implode(',', $_POST['parent_cat']);
    $addCat =  mysqli_query($conn, "INSERT INTO categories (name, parent_cat, image, description) VALUES('$catName', '$parent_cat', '$image', '$description')");
    // header('Location:addCat.php');
}
?>
<div class="container">
    <h2>Categories</h2>
        <strong>Add categories</strong>
    <form class="form-group" action="" method="post" enctype="multipart/form-data">
        <label>Enter a category</label>
        <input type="text" name="category" placeholder="Enter a category"><br>
        <label>Choose A Parent Category </label>
        <?php while($row = mysqli_fetch_array($cat)): ?>
        <input type="checkbox" name="parent_cat[]" id="" value="<?php echo $row['id'] ?>" ><?php echo $row['name']; ?>
            <?php endwhile; ?>
       <br>
        <label>Category Image</label>
        <input type="file" name="image" placeholder="Enter a category">
        <label>Category Description</label>
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <input type="submit" name="cat" class="form-control  btn btn-primary" value="Add a category">
    </form>
</div>
</body>
</html>