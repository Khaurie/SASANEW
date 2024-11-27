
<?php

include('../includes/connect.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data (replace with actual inputs as needed)
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $amount_due = mysqli_real_escape_string($con, $_POST['amount_due']);
    $invoice_number = mysqli_real_escape_string($con, $_POST['invoice_number']);
    $total_products = mysqli_real_escape_string($con, $_POST['total_products']);
    $order_status = mysqli_real_escape_string($con, $_POST['order_status']);

    // Insert query
    $insert_order = "INSERT INTO `order_logs` 
                     (`user_id`, `amount_due`, `invoice_number`, `total_products`, `order_status`) 
                     VALUES 
                     ('$user_id', '$amount_due', '$invoice_number', '$total_products', '$order_status')";
    if (mysqli_query($con, $insert_order)) {
        echo "<div class='alert alert-success'>Order logged successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }
}

// Fetch and display all order logs
echo "<h3 class='text-center text-success'>Order Logs</h3>";
$query = "SELECT * FROM `order_logs` ORDER BY `order_date` DESC";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table table-bordered mt-5 text-center'>
            <thead class='bg-success'>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Due Amount</th>
                    <th>Invoice Number</th>
                    <th>Total Products</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['order_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['amount_due']}</td>
                <td>{$row['invoice_number']}</td>
                <td>{$row['total_products']}</td>
                <td>{$row['order_date']}</td>
                <td>{$row['order_status']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<h4 class='text-center text-danger mt-5'>No order logs found</h4>";
}
?>

<!-- Example Form to Insert Order Logs -->
<form method="POST" class="mt-5">
    <h4 class="text-center">Log a New Order</h4>
    <div class="form-group">
        <label for="user_id">User ID</label>
        <input type="number" class="form-control" name="user_id" required>
    </div>
    <div class="form-group">
        <label for="amount_due">Due Amount</label>
        <input type="number" step="0.01" class="form-control" name="amount_due" required>
    </div>
    <div class="form-group">
        <label for="invoice_number">Invoice Number</label>
        <input type="text" class="form-control" name="invoice_number" required>
    </div>
    <div class="form-group">
        <label for="total_products">Total Products</label>
        <input type="number" class="form-control" name="total_products" required>
    </div>
    <div class="form-group">
        <label for="order_status">Order Status</label>
        <select class="form-control" name="order_status" required>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success mt-3">Log Order</button>
</form>