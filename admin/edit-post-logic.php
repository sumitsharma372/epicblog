<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ?: 0;

    // check and validate input values
    if (!$title) {
        $_SESSION['edit-post'] = "Title error";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "category id errar";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "body error";
    } else {
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }
            // work on new thumbnail
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if (in_array($extension, $allowed_files)) {
                // make sure thumbnail is not too large
                if ($thumbnail['size'] < 20000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Filesize is too large";
                }
            } else {
                $_SESSION['edit-post'] = "Supported file formats - png, jpg, jpeg, webp";
            }
        }
    }
    if (isset($_SESSION['edit-post'])) {
        header('location:' . ROOT_URL . 'admin/edit_posts.php');
        die();
    } else {
        if ($is_featured == 1) {
            $zero_all_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_featured_result = mysqli_query($conn, $zero_all_featured_query);
        }

        // set thumbnail name if a new one was uploaded else keep old thumbnail

        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $sql = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert', category_id = $category_id, is_featured = $is_featured WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
    }

    if (!mysqli_errno($conn)) {
        $_SESSION['edit-post-success'] = "Post updated successully";
    }
}

header('location: ' . ROOT_URL . 'admin/');
