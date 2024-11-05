<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "is_project";
$connect = mysqli_connect("localhost", "root","");
mysqli_query($connect,"Create database IF NOT EXISTS is_project");
mysqli_select_db($connect,"is_project") or die("can not select database");
//$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql="create table IF NOT EXISTS details("."Id varchar(15) NOT NULL UNIQUE,"."Name text NOT NULL,"."Email varchar(45) NOT NULL UNIQUE,"."Password Varchar(100) NOT NULL,"."Salt Varchar(300) NOT NULL,"."Graphical varchar(255) NOT NULL,"."Picture varchar(255) NOT NULL)";
mysqli_query($connect,$sql);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>