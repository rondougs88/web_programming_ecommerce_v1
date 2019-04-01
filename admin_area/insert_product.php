<!DOCTYPE>

<?php

include "includes/db.php";

?>
<html>
	<head>
		<title>Inserting Product</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/shop-homepage.css" rel="stylesheet">


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
	</head>

<body bgcolor="skyblue">

<?php include "../navigation.php";?>

	<form action="insert_product.php" method="post" enctype="multipart/form-data">

		<table align="center" width="795" border="2" bgcolor="#187eae">

			<tr align="center">
				<td colspan="7"><h2>Insert New Post Here</h2></td>
			</tr>

			<tr>
				<td align="right"><b>Product Title:</b></td>
				<td><input type="text" name="product_title" size="60" required/></td>
			</tr>

			<tr>
				<td align="right"><b>Product Category:</b></td>
				<td>
				<select name="product_cat" >
					<option>Select a Category</option>
					<?php
$get_cats = "select * from categories";

$run_cats = mysqli_query($con, $get_cats);

while ($row_cats = mysqli_fetch_array($run_cats)) {

    $cat_id = $row_cats['cat_id'];
    $cat_title = $row_cats['cat_title'];

    echo "<option value='$cat_id'>$cat_title</option>";

}

?>
				</select>


				</td>
			</tr>

			<tr>
				<td align="right"><b>Product Brand:</b></td>
				<td>
				<select name="product_brand" >
					<option>Select a Brand</option>
					<?php
$get_brands = "select * from brands";

$run_brands = mysqli_query($con, $get_brands);

while ($row_brands = mysqli_fetch_array($run_brands)) {

    $brand_id = $row_brands['brand_id'];
    $brand_title = $row_brands['brand_title'];

    echo "<option value='$brand_id'>$brand_title</option>";

}

?>
				</select>


				</td>
			</tr>

			<tr>
				<td align="right"><b>Product Image:</b></td>
				<td><input type="file" name="product_image" /></td>
			</tr>

			<tr>
				<td align="right"><b>Product Price:</b></td>
				<td><input type="text" name="product_price" required/></td>
			</tr>

			<tr>
				<td align="right"><b>Product Description:</b></td>
				<td><textarea name="product_desc" cols="20" rows="10"></textarea></td>
			</tr>

			<tr>
				<td align="right"><b>Product Keywords:</b></td>
				<td><input type="text" name="product_keywords" size="50" required/></td>
			</tr>

			<tr align="center">
				<td colspan="7"><input type="submit" name="insert_post" value="Insert Product Now"/></td>
			</tr>

		</table>


	</form>


</body>
</html>
<?php

if (isset($_POST['insert_post'])) {

    //getting the text data from the fields
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];
    $product_keywords = $_POST['product_keywords'];
    $inserted_on = date("Y-m-d H:i:s");

    //getting the image from the field
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];

    move_uploaded_file($product_image_tmp, "uploads/product_images/$product_image");

    $insert_product = "insert into products
								 (product_cat,
								 product_brand,
								 product_title,
								 product_price,
								 product_desc,
								 product_image,
								 product_keywords,
								 inserted_on)
								 values
								 ('$product_cat',
								 '$product_brand',
								 '$product_title',
								 '$product_price',
								 '$product_desc',
								 '$product_image',
								 '$product_keywords',
								 '$inserted_on')";

    $insert_pro = mysqli_query($con, $insert_product);

    if ($insert_pro) {

        echo "<script>alert('Product Has been inserted!')</script>";
        echo "<script>window.open('insert_product.php','_self')</script>";

    }
}

?>



