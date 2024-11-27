<?php
// Assuming you've connected to the database
// $con is your database connection variable (use mysqli or PDO to connect)

include('../includes/connect.php'); // Make sure to include your database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <!-- Add any additional CSS or JS here -->
</head>
<body>
    <h3 class="text-center text-success">All Products</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-success">
            <tr class="text-center">
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Total Sold</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary">
            <?php
            // Query to get all products
            $get_products = "SELECT * FROM `products`";
            $result = mysqli_query($con, $get_products);
            $number = 0;

            // Loop through the products
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $quantity = $row['quantity']; // Added quantity
                $status = $row['status'];
                $number++;

                // Query to get total sold
                $get_count = "SELECT * FROM `orders_pending` WHERE product_id = $product_id";
                $result_count = mysqli_query($con, $get_count);
                $rows_count = mysqli_num_rows($result_count);
            ?>
                <tr class="text-center">
                    <td><?php echo $number; ?></td>
                    <td><?php echo $product_title; ?></td>
                    <td>
                        <img src="./product_images/<?php echo $product_image1; ?>" class="product_img" style="width: 100px; height: auto;" />
                    </td>
                    <td><?php echo number_format($product_price, 2); ?></td>
                    <td><?php echo $quantity; ?></td> <!-- Display Quantity -->
                    <td><?php echo $rows_count; ?></td> <!-- Total Sold -->
                    <td><?php echo $status == 'true' ? 'Active' : 'Inactive'; ?></td> <!-- Status -->
                    <td>
                        <a href="index.php?edit_products=<?php echo $product_id; ?>">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    </td>
                    <td>
                        <a href="index.php?delete_product=<?php echo $product_id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                            <i class="fa-solid fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
