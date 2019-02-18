<?php
include("../dbConnection.php");
session_start();
if(isset($_SESSION['admin']) && isset($_GET['test_id'])){
    
    $test_id = $_GET['test_id'];
    $sql = "DELETE FROM questions WHERE test_id='$test_id'";
    $result = $conn->query($sql);
    
    $sql = "DELETE FROM test WHERE test_id='$test_id'";
    $result = $conn->query($sql);
    
    
    header("location: tests.php");
    
}
else{
    header("location: tests.php");
}
?>