<?php
 include "canfig.php";

 $post_id = $_GET['id'];
 $post_id = $_GET['catid'];

 $query = "DELETE FROM post WHERE post_id = {$post_id};";
 $query .= "UPDATE category SET post= post - 1 WHERE category_id = {$cat_id}";

 if(mysqli_multi_query($connection, $query)){
     header("location: ../admin/post.php");
 }else{
     echo "Post delete Query Faild";
 }

 echo mysqli_error($connection);


?>