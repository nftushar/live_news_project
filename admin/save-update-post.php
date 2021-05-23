<?php
include "config.php";

if (empty($_FILES['new-image']['name'])) {
    $new_name = $_POST['old_image'];
    // var_dump ($new_name);
}else {
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_temp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
    // $file_ext  = end(explode('.', $file_name));
    $file_exp  = explode('.', $file_name);
    $file_ext  = end($file_exp);


    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "This extension file not allowed, please choose a JPEG, JPG or PNG  file";
    }

    if ($file_size > 2097152) {
        $errors[] = "File size must be 2MB or less";
    }

    $new_name = time() . "-" . basename($file_name);
    $target = "upload/" . $new_name;

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }

    $query = "UPDATE post SET  
    title = '{$_POST["post_title"]}', 
    description ='{$_POST["postdesc"]}',
    category ='{$_POST["category"]}',  
    post_img ='{$_POST["image_name"]}'
    WHERE post_id =  '{$_POST["post_id"]}';";

    // $query = "UPDATE post SET  
    // title = '{$post_title}', 
    // description ='{$postdesc}',
    // category ='{$category}',  
    // post_img ='{$new_image}'
    // WHERE post_id =  '{$post_id}';";

    // echo mysqli_error($connection,$query);

    if ($_post['old_category'] != $_POST['category']) {
        $query .= "UPDATE category SET post = post -1 WHERE category_id = {$_POST['old_category']};";
        $query .= "UPDATE category SET post = post -1 WHERE category_id = {$_POST['category']};";

        // $query.= "UPDATE category SET post = post -1 WHERE category_id = {$_POST['category']};";---
        // var_dump($query);

    }

    $result = mysqli_multi_query($connection, $query);


    if ($result) {
        header("location: ../admin/post.php");
    } else {
        echo "Update Query Failed";
    }
}