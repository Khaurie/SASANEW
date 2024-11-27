<?php
include('../includes/connect.php');

if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];

    // Fetch product details
    $get_data = "SELECT * FROM `products` WHERE product_id=$edit_id";
    $result = mysqli_query($con, $get_data);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $category_id = $row['category_id'];
        $brand_id = $row['brand_id'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $product_price = $row['product_price'];
        $quantity = $row['quantity'];

        // Fetch category name
        $select_category = "SELECT * FROM `categories` WHERE category_id=$category_id";
        $result_category = mysqli_query($con, $select_category);
        $category_title = $result_category ? mysqli_fetch_assoc($result_category)['category_title'] : "Unknown";

        // Fetch brand name
        $select_brand = "SELECT * FROM `brands` WHERE brand_id=$brand_id";
        $result_brand = mysqli_query($con, $select_brand);
        $brand_title = $result_brand ? mysqli_fetch_assoc($result_brand)['brand_title'] : "Unknown";
    } else {
        echo "<script>alert('Product not found.')</script>";
        echo "<script>window.open('./index.php', '_self')</script>";
    }
}

// Update Product
if (isset($_POST['edit_product'])) {
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_description = mysqli_real_escape_string($con, $_POST['product_desc']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $category_id = $_POST['product_category'];
    $brand_id = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Handling product images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    $temp_name1 = $_FILES['product_image1']['tmp_name'];
    $temp_name2 = $_FILES['product_image2']['tmp_name'];
    $temp_name3 = $_FILES['product_image3']['tmp_name'];

    // If there are new images uploaded, move them to the directory
    if (!empty($product_image1)) {
        move_uploaded_file($temp_name1, "./product_images/$product_image1");
    } else {
        $product_image1 = $row['product_image1'];  // Retain existing image if not updated
    }

    if (!empty($product_image2)) {
        move_uploaded_file($temp_name2, "./product_images/$product_image2");
    } else {
        $product_image2 = $row['product_image2'];  // Retain existing image if not updated
    }

    if (!empty($product_image3)) {
        move_uploaded_file($temp_name3, "./product_images/$product_image3");
    } else {
        $product_image3 = $row['product_image3'];  // Retain existing image if not updated
    }

    // SQL query to update the product
    $update_product = "UPDATE `products` SET 
        product_title = '$product_title',
        product_description = '$product_description',
        product_keywords = '$product_keywords',
        category_id = '$category_id',
        brand_id = '$brand_id',
        product_image1 = '$product_image1',
        product_image2 = '$product_image2',
        product_image3 = '$product_image3',
        product_price = '$product_price',
        quantity = '$quantity'
        WHERE product_id = '$edit_id'";

    $run_update = mysqli_query($con, $update_product);

    if ($run_update) {
        echo "<script>alert('Product updated successfully.')</script>";
        echo "<script>window.open('./index.php', '_self');</script>";
    } else {
        echo "<script>alert('Failed to update product.')</script>";
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Product Title -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" value="<?php echo $product_title; ?>" name="product_title" class="form-control" required="required">
        </div>

        <!-- Product Description -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_desc" class="form-label">Product Description</label>
            <input type="text" id="product_desc" name="product_desc" value="<?php echo $product_description; ?>" class="form-control" required="required">
        </div>

        <!-- Product Keywords -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="product_keywords" name="product_keywords" value="<?php echo $product_keywords; ?>" class="form-control" required="required">
        </div>

        <!-- Product Categories -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Categories</label>
            <select name="product_category" class="form-select">
                <option value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                <?php
                $select_category_all = "SELECT * FROM `categories`";
                $result_category_all = mysqli_query($con, $select_category_all);
                while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                    $cat_title = $row_category_all['category_title'];
                    $cat_id = $row_category_all['category_id'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
                ?>
            </select>
        </div>

        <!-- Product Brands -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_brands" class="form-label">Product Brands</label>
            <select name="product_brands" class="form-select">
                <option value="<?php echo $brand_id; ?>"><?php echo $brand_title; ?></option>
                <?php
                $select_brand_all = "SELECT * FROM `brands`";
                $result_brand_all = mysqli_query($con, $select_brand_all);
                while ($row_brand_all = mysqli_fetch_assoc($result_brand_all)) {
                    $br_title = $row_brand_all['brand_title'];
                    $br_id = $row_brand_all['brand_id'];
                    echo "<option value='$br_id'>$br_title</option>";
                }
                ?>
            </select>
        </div>

        <!-- Product Images -->
        <?php for ($i = 1; $i <= 3; $i++) { ?>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="product_image<?php echo $i; ?>" class="form-label">Product Image<?php echo $i; ?></label>
                <div class="d-flex">
                    <input type="file" id="product_image<?php echo $i; ?>" name="product_image<?php echo $i; ?>" class="form-control w-90 m-auto">
                    <img src="./product_images/<?php echo ${"product_image$i"}; ?>" alt="" class="product_img">
                </div>
            </div>
        <?php } ?>

        <!-- Product Price -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" id="product_price" value="<?php echo $product_price; ?>" name="product_price" class="form-control" required="required">
        </div>

        <!-- Quantity -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="quantity" class="form-label">Product Quantity</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" class="form-control" required="required">
        </div>

        <!-- Submit -->
        <div class="w-50 m-auto">
            <input type="submit" name="edit_product" value="Update Product" class="btn btn-success px-3 mb-3">
        </div>
    </form>
</div>
