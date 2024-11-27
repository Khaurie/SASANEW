<?php
include('../includes/connect.php'); // Include the database connection

// Fetch payments from the database
$get_payments = "SELECT * FROM `user_payments`";
$result = mysqli_query($con, $get_payments);
$row_count = mysqli_num_rows($result);
?>

<h3 class="text-center text-success">All Payments</h3>
<table class="table table-bordered mt-5 text-center">
    <thead class="bg-success">
        <?php
        if ($row_count == 0) {
            echo "<h2 class='text-danger text-center mt-5'>No Payments received yet</h2>";
        } else {
            echo "<tr>
                <th>Sl no</th>
                <th>Invoice Number</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Order Date</th>
                <th>Delete</th>
            </tr>
    </thead>
    <tbody>";
            $number = 0;
            while ($row_data = mysqli_fetch_assoc($result)) {
                $order_id = $row_data['order_id'];
                $payment_id = $row_data['payment_id'];
                $amount = $row_data['amount'];
                $invoice_number = $row_data['invoice_number'];
                $payment_mode = $row_data['payment_mode'];
                $date = $row_data['date'];
                $number++;

                echo "<tr>
                    <td>$number</td>
                    <td>$invoice_number</td>
                    <td>$amount</td>
                    <td>$payment_mode</td>
                    <td>$date</td>
                    <td><a href='?delete_payment=$payment_id'><i class='fa-solid fa-trash'></i></a></td>
                </tr>";
            }
        }
        ?>
    </tbody>
</table>

<?php
// Check if delete payment action is triggered
if (isset($_GET['delete_payment'])) {
    // Sanitize the input to prevent SQL injection
    $payment_id = mysqli_real_escape_string($con, $_GET['delete_payment']);

    // SQL query to delete the payment
    $delete_payment = "DELETE FROM `user_payments` WHERE payment_id = '$payment_id'";

    // Execute the query
    $run_delete = mysqli_query($con, $delete_payment);

    if ($run_delete) {
        // Show success message and refresh the page
        echo "<script>alert('Payment deleted successfully');</script>";
        echo "<script>window.location.href = 'your_page.php';</script>"; // Replace 'your_page.php' with the correct page
    } else {
        // Show error message
        echo "<script>alert('Failed to delete payment');</script>";
    }
}
?>
