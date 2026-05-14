<?php
$conn=new mysqli("localhost","root","","test_db");
if($conn->connect_error){
    die("connection error:".$conn->connect_error);
}


?>