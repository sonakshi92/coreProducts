<?php
define('title', 'view products');
include 'header.php';

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = $_GET['type'];
	if($type == 'status'){
		$operation = $_GET['operation'];
		$id = $_GET['id'];
		if($operation == 'active'){
			$status = '1';
		}else{
			$status = '0';
		}
		$update_status_sql="update products set status='$status' where id='$id'";
		mysqli_query($conn,$update_status_sql);
	}
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id=$id";
    $del = mysqli_query($conn, $sql);
    echo "Record Deleted";
}
 ?>


<form action="" method="POST">
<input type="hidden" name="id" value="<?php echo $id;?>">

<?php 
$prod = mysqli_query($conn, "SELECT * FROM products");
?>

<table class="table table-bordred table-striped" id="view">
<thead>
    <tr>
        <th>  Products  </th>
        <th>  Category  </th>
        <th>  Sub Category  </th>
        <th>  Image  </th>
        <th>  SKU  </th>
        <th>  Description  </th>
        <th>  Quantity  </th>
        <th>  Price  </th>
        <th>  status  </th>
        <th>  Action  </th>
    </tr>
</thead>

<tbody>   
<?php while($rows = mysqli_fetch_assoc($prod)) {
$cat = mysqli_query($conn, "SELECT * FROM categories");
$sub_cat = mysqli_query($conn, "SELECT * FROM sub_categories");
?>
    <tr>
        <td>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <b> <input type="text" name="name" value="<?php echo $rows['name'];?>"></b>
        </td>
        <td>
            <i> <?php
                     $cat_arr = $rows['cat_id'];
                     echo "<select name='category[]' class='select' multiple>";
                        while($selCat = mysqli_fetch_array($cat)){
                            if(in_array($cat_arr, $selCat)){
                                echo "<option selected value='". $selCat['id'] ."'>" . $selCat['name'] ."</option>";
                            } else{
                                echo "<option value='". $selCat['id'] ."'>" . $selCat['name'] ."</option>";
                            }
                        }
                    echo "</select>";
                 ?>
            </i>
                
        </td>
        <td>
            <i> <?php
                    $sub_cat_arr = $rows['sub_cat_id'];
                    echo "<select name='category[]' class='select' multiple>";
                    while($selSubCat = mysqli_fetch_array($sub_cat)){
                        if(in_array($sub_cat_arr, $selSubCat)){
                            echo "<option selected value='". $selSubCat['id'] ."'>" . $selSubCat['name'] ."</option>";
                        } else{
                            echo "<option value='". $selSubCat['id'] ."'>" . $selSubCat['name'] ."</option>";
                        }
                    }
                echo "</select>";
                    ?>
                </i>
        </td>
        <td>
            <img src="<?php echo $rows['image']; ?>" alt="Product Image" width=50>
        </td>
        <td>
            <i><?php echo $rows['sku']; ?></i>
        </td>
        <td>
            <i><input type="text" name="" value="<?php echo $rows['short_description']; ?>"></i>
        </td>
        <td>
            <i><input type="text" name="" value="<?php echo $rows['qty'];?>"></i>
        </td>
        <td>
            <i><input type="text" name="" value="<?php echo $rows['mrp'];?>"></i>
        </td>
        <td>
        <?php
			if($rows['status']==1){
			    echo "<a href='?type=status&operation=deactive&id=".$rows['id']."'>Active</a>&nbsp;";
			}else{
				echo "<a href='?type=status&operation=active&id=".$rows['id']."'>Deactive</a>&nbsp;";
				}					
        ?>
        </td>
        <td>
            <a class="btn btn-primary btn-sm a-btn-slide-text"> update</a>
            <a href="products.php?delete=<?php echo $rows['id']; ?>"class="btn btn-danger btn-sm a-btn-slide-text">
         <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </td>
    </tr> 
    <?php  }?>
    </tbody>
</table>
</form>
<script>
$(document).ready( function () {
    $('#view').DataTable();
} );
</script>

</div></div>
</body>
</html>