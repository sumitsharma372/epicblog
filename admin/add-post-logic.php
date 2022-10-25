<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to zero if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Enter Post Title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select Post Category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Please upload an thumbnail";
    } else {
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // make sure file is an image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $extension_separation = explode('.', $thumbnail_name);
        $extension = end($extension_separation);

        if (in_array($extension, $allowed_extensions)) {
            // make sure image is not too large
            if ($thumbnail['size'] < 20000000) {
                // upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "Filesize is too big!";
            }
        } else {
            $_SESSION['add-post'] = "Image format should be png, jpg, jpeg, webp";
        }
    }

    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_post.php');
        die();
    } else {
        // set is_featured for all other post to zero is if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_sql = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_sql);
        }

        // insert post into database
        $query = "INSERT INTO posts (title,body,thumbnail,category_id, author_id, is_featured) VALUES ('$title','$body','$thumbnail_name',$category_id,$author_id,$is_featured)";
        $result = mysqli_query($conn, $query);

        if (!mysqli_errno($conn)) {
            $_SESSION['add-post-success'] = "Post added successfully";
            header('location:' . ROOT_URL . 'admin/');
            die();
        }
    }
} else {
    header('location:' . ROOT_URL . 'admin/add_post.php');
    die();
}
