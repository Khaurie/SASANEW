<?php
// Establish a connection to the MySQL database
$con = mysqli_connect('localhost', 'root', '', 'online_shopping');

// Check if the connection was successful
if(!$con){
    // Provide a more detailed error message
    die("Connection failed: " . mysqli_connect_error());
}
?>
