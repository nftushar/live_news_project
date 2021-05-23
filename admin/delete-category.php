<?php
// echo "Hello";
include 'config.php';
$category_id =  $_GET['id'];


$query = "DELETE FROM `category` WHERE  category_id = '{$category_id}'";

// var_dump($query);

$result = mysqli_query($connection, $query);

if($result){
    header("location: category.php");
}else{
    echo"category not delete";
}
// mysql_close($connection);

?>



