<?php
include "config.php";

if (isset($_FILES['fileToUpload'])) {
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp  = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    // $file_exp  = end(explode('.', $file_name));
    $file_exp  = explode('.', $file_name);
    $file_ext  = end($file_exp);


    $extensions = array("jpeg","jpg","png");

    if (in_array($file_ext, $extensions) === false) 
    {
        $errors[] = "This extension file not allowed, please choose a JPEG, JPG or PNG file.";
    }

    if ($file_size > 2097152)
    {
        $errors[] = "File size must be 2MB or less";
    }
    $new_name = time(). "-".basename($file_name);
    $target = "upload/".$new_name;

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

// if (isset($_POST['submit'])) {
// include 'config.php';
session_start();

// if (isset($_POST['submit'])) {
//     include 'config.php';

    $title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $description = mysqli_real_escape_string($connection, $_POST["postdesc"]);
    $category    = mysqli_real_escape_string($connection, $_POST["category"]);
    $data        = date("d M, Y");
    $author      = $_SESSION['user_id'];

    // $category_id    = $_SESSION["category_id"];

    // $category_id = mysqli_real_escape_string($connection, $_POST[""]),

    $sql = "INSERT INTO `post`(`title`, `description`, `category`, `post_date`, `author`, `post_img`)  
                      VALUES ('{$title}','{$description}', '{$category}', '{$data}', '{$author}','{$new_name}');";
    // print_r($sql);
    $sql .= "UPDATE `category` SET  `post` = post + 1 WHERE `category_id` = '{$category}'";

    // var_dump($sql); 

    if (mysqli_multi_query($connection, $sql)) {
        header("location: post.php");
    } else {
        echo "<div class='alert alert-danger'>Form Query Failed.</div>";
    }
// }


?>



