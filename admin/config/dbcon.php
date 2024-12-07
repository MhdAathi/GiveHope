<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "give_hope";

$con = mysqli_connect("$host", "$username", "$password", "$database");

if (!$con) {
    header("Location: ../errors/dberror.php");
    die();
}
