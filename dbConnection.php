<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "portal";

//create connection
$conn=new mysqli($servername,$username,$password);

// create database
$sql = "CREATE  SCHEMA IF NOT EXISTS `portal` DEFAULT CHARACTER SET utf8 ";
$conn->query($sql);

$conn=new mysqli($servername,$username,$password,$db);

?>