<?php
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    // Collect form data
    $product_title = $_POST['product_title'];
    $description = $_POST['description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category']; // Category ID from form
    $product_brands = $_POST['product_brands'];     // Brand ID from form
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['quantity'];
    $product_status = 'true';

    // Access images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    // Validate form fields
    if (
        empty($product_title) || empty($description) || empty($product_keywords) ||
        empty($product_category) || empty($product_brands) || empty($product_price) ||
        empty($product_quantity) || empty($product_image1) || empty($product_image2) || empty($product_image3)
    ) {
        echo "<script>alert('Please fill all the fields.')</script>";
        exit();
    } else {
        // Move uploaded files to target directory
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        // Insert query for products
        $insert_products = "
            INSERT INTO `products` 
            (product_title, product_description, product_keywords, category_id, brand_id, product_image1, product_image2, product_image3, product_price, quantity, date, status) 
            VALUES 
            ('$product_title', '$description', '$product_keywords', '$product_category', '$product_brands', '$product_image1', '$product_image2', '$product_image3', '$product_price', '$product_quantity', NOW(), '$product_status')";

        $result_query = mysqli_query($con, $insert_products);

        // Check for success
        if ($result_query) {
            echo "<script>alert('Product inserted successfully!')</script>";
        } else {
            echo "<script>alert('Failed to insert product. Please try again.')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center text-success">Insert Products</h1>
        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" required>
            </div>

            <!-- Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Product Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter product description" rows="3" required></textarea>
            </div>

            <!-- Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords" autocomplete="off" required>
            </div>

            <!-- Categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_category" class="form-label">Product Category</label>
                <select name="product_category" id="product_category" class="form-select" required>
                    <option value="">Select a category</option>
                    <?php
                    $select_query = "SELECT * FROM `categories`";
                    $result_query = mysqli_query($con, $select_query);
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];
                        echo "<option value='$category_id'>$category_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Brands -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_brands" class="form-label">Product Brand</label>
                <select name="product_brands" id="product_brands" class="form-select" required>
                    <option value="">Select a brand</option>
                    <?php
                    $select_query = "SELECT * FROM `brands`";
                    $result_query = mysqli_query($con, $select_query);
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        $brand_title = $row['brand_title'];
                        $brand_id = $row['brand_id'];
                        echo "<option value='$brand_id'>$brand_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Images -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Product Image 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control" required>
            </div>

            <!-- Quantity -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="quantity" class="form-label">Product Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter product quantity" required>
            </div>

            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" required>
            </div>

            <!-- Submit Button -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-success px-4" value="Insert Product">
            </div>
        </form>
    </div>
</body>
</html>
