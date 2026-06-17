<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM students WHERE id='$id'");

header("Location: student.php");
?>