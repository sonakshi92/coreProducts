<?php
define('title', 'Add New Product');
include 'header.php'; 
$product = $errproduct = $errsku = $image = "";
if(isset($_POST['add'])){
  // print_r($_POST);exit;
  $product =$_POST['product'];
  $sku = $_POST['sku'];
  $category = implode(',', $_POST['category']);
  $sub_category = implode(',', $_POST['sub_category']);
  $file = $_FILES['image'];
  $short_description = $_POST['short_description'];
  $description = $_POST['description'];
  $quantity = $_POST['quantity'];
  $purchase_price = $_POST['purchase_price'];
  $mrp = $_POST['mrp'];
  
  $filename = $file['name'];
  $filepath = $file['tmp_name'];
  $image = 'products/'.$filename;
  move_uploaded_file($filepath, $image);

  if(empty($product && $sku)){
    $errproduct .= "Please enter product name and SKU <br>";
  }

  if(!empty($sku)){
    $sql = "SELECT sku FROM products where sku='$sku'";
    $search = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($search);
    if($row > 0) {
     $errsku .= "SKU already exists. Please try other sku <br>";
    }else{
      if($product != ''){
        $sql = "SELECT product FROM products where product='$product'";
        $search = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($search);
        if($rows > 0) {
          $errproduct .= "Product already available <br>";
        } else {
          $sql3 = "INSERT INTO products (name, sku, cat_id, sub_cat_id, image, short_description, description, qty, purchase, mrp, status) VALUES('$product', '$sku', '$category', '$sub_category', '$image', '$short_description', '$description', '$quantity', '$purchase_price', '$mrp', '1')";
          $add = mysqli_query($conn, $sql3);
          echo "Product Added";
          header('location: addProd.php');
        }
      }
    }
  }
}
?>

<div class="container">
    <form action="" method="POST" class="form-row" enctype="multipart/form-data">
    <div class="form-group">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label class="form-label">SKU : </label>
      <input type="text" class="form-control" name="sku" value=<?php echo substr(md5($product), 0,10); ?>>
        <span style="color:red"> <?php echo $errsku;?></span>

    <label> Product Name : </label>
      <input type="text" name="product" class="form-control" value="<?php echo $product; ?>" required> 
        <span style="color:red"> <?php echo $errproduct ?></span>

    <label class="form-label select-label">category : </label>
        <?php $categories = mysqli_query($conn, "SELECT * FROM categories"); ?>
        <select name="category[]" class="select" multiple>
        <?php while($rows = mysqli_fetch_assoc($categories)) {?>
          <option value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
          <?php } ?>
        </select><br>

    <label class="form-label select-label">Sub category : </label>
        <?php $sub_categories = mysqli_query($conn, "SELECT * FROM sub_categories"); ?>
        <select name="sub_category[]" class="select" multiple>
        <?php while($rows = mysqli_fetch_assoc($sub_categories)) {?>
          <option value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
          <?php } ?>
        </select><br>

    <label>  Image: <input type="file" class="form-control" name="image" required></label><br>

    <label>Short Description:</label> 
        <textarea name="short_description" rows="2" cols="50" class="form-control" required> </textarea>

    <label> Description of Product :</label> 
        <textarea name="description" rows="4" cols="50" class="form-control" required></textarea>

    <label>Quantity :</label> 
        <input type="number" name="quantity" class="form-control" required>

    <label>Purchase Price : </label>
        <input type="number" name="purchase_price" class="form-control" required>

    <label> MRP :</label> 
        <input type="number" name="mrp" class="form-control" value="<?php echo $mrp; ?>" required>
        
    <button type="submit" name="add" class="btn btn-primary mb-2">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
        <span>ADD</button></span>
    </form>
</div>
</div>
</script>
</body>
</html>