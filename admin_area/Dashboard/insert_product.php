<?php include "./admin_panel_header.php" ?>


<!-- Custom styles for this template -->
<link href="../../css/insert_product.css" rel="stylesheet">

<!-- Script for Text area input -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
	tinymce.init({
		selector: 'textarea'
	});
</script>

<?php
if (!isLoggedIn() || !isAdmin()) {
	echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
	exit();
}
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	<form action="insert_product.php" method="post" enctype="multipart/form-data">
		<h2 style="text-align: center">Create New Product</h2>

		<!-- <div class="form-group row">
			<label for="protitle" class="col-sm-2 col-form-label">Product Title</label>
			<div class="col-sm-10">
				<input type="text" name="product_title" id="protitle" size="60" class="form-control" required>
			</div>
		</div> -->

		<table class="table" align="center" width="795">
			<tr>
				<td align="right"><b>Product Title:</b></td>
				<td>
					<input type="text" name="product_title" id="protitle" size="60" class="form-control" required>
				</td>
			</tr>
			<tr>
				<td align="right"><b>Product Category:</b></td>
				<td>
					<select name="product_cat">
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
					<select name="product_brand">
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
				<td align="right"><b>Primary Product Image:</b></td>
				<td><input type="file" name="product_image"></td>
			</tr>

			<tr>
				<td align="right"><b>Product Images:</b></td>
				<td><input type="file" name="product_images[]" multiple></td>
			</tr>

			<tr>
				<td align="right"><b>Product Price:</b></td>
				<td><input type="number" name="product_price" required /></td>
			</tr>

			<tr>
				<td align="right"><b>Available Quantity:</b></td>
				<td><input type="number" name="product_qty" required /></td>
			</tr>

			<tr>
				<td align="right"><b>Product Description:</b></td>
				<td><textarea name="product_desc" cols="20" rows="10"></textarea></td>
			</tr>

			<tr>
				<td align="right"><b>Product Keywords:</b></td>
				<td><input type="text" name="product_keywords" size="50" required /></td>
			</tr>

			<tr align="center">
				<td colspan="7"><input type="submit" name="insert_post" value="Insert Product Now" /></td>
			</tr>

		</table>


	</form>
</main>
<?php include "./admin_panel_footer.php"; ?>

<?php

if (isset($_POST['insert_post'])) {

	$allowTypes = array('jpg', 'png', 'jpeg', 'gif');
	$targetDir = "../uploads/product_images/";

	//getting the text data from the fields
	$product_title = $_POST['product_title'];
	$product_cat = $_POST['product_cat'];
	$product_brand = $_POST['product_brand'];
	$product_price = $_POST['product_price'];
	$product_qty = $_POST['product_qty'];
	$product_desc = $_POST['product_desc'];
	$product_keywords = $_POST['product_keywords'];
	$product_keywords = $_POST['product_keywords'];
	$inserted_on = date("Y-m-d H:i:s");
	$last_id = '';

	// Get the highest id number from products table
	$get_last_id = "SELECT product_id FROM products ORDER BY product_id DESC LIMIT 0, 1";
	$run_q = mysqli_query($con, $get_last_id);
	if (mysqli_num_rows($run_q) > 0) {
		while ($row_pro = mysqli_fetch_array($run_q)) {
			$last_id = $row_pro['product_id'];
		}
	}
	if (empty($last_id)) {
		$last_id = 1;
	}

	//getting the image from the field
	$ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
	$product_image = "image_" . $last_id . '.' . $ext;
	$product_image_tmp = $_FILES['product_image']['tmp_name'];

	move_uploaded_file($product_image_tmp, $targetDir . $product_image);

	$insert_product = "insert into products" .
		"(product_cat,product_brand,product_title,product_price,product_desc,product_image,product_keywords,inserted_on)"
		. "values"
		. "('$product_cat','$product_brand','$product_title','$product_price','$product_desc','$product_image','$product_keywords','$inserted_on')";

	$insert_pro = mysqli_query($con, $insert_product);

	$prod_id = $con->insert_id;

	// Update product inventory
	$insert_product_qty = "INSERT into products_inventory" . "(product_id,qty)" . "values" . "('$prod_id','$product_qty')";

	$insert_pro_qty = mysqli_query($con, $insert_product_qty);

	// Process the product images being uploaded
	if (!empty(array_filter($_FILES['product_images']['name']))) {
		foreach ($_FILES['product_images']['name'] as $key => $val) {
			// File upload path
			// $fileName = basename($_FILES['product_images']['name'][$key]);
			// $targetFilePath = $targetDir . $fileName;

			$ext = pathinfo($_FILES['product_images']['name'][$key], PATHINFO_EXTENSION);
			$fileName = "image" . $key . "_" . $last_id . '.' . $ext;

			// Check whether file type is valid
			// $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
			if (in_array($ext, $allowTypes)) {
				// Upload file to server
				if (move_uploaded_file($_FILES["product_images"]["tmp_name"][$key], $targetDir . $fileName)) {
					// Image db insert sql
					// $insertValuesSQL .= "('" . $fileName . "', NOW()),";
					$insert_images = "INSERT into product_images (product_id, image_name) values ('$prod_id', '$fileName')";
					mysqli_query($con, $insert_images);
				} else {
					$errorUpload .= $_FILES['product_images']['name'][$key] . ', ';
				}
			} else {
				$errorUploadType .= $_FILES['product_images']['name'][$key] . ', ';
			}
		}
	}

	if ($insert_pro) {

		echo "<script>alert('Product Has been inserted!')</script>";
		echo "<script>window.open('insert_product.php','_self')</script>";
	}
}

?>