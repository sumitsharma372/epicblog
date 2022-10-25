<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;

        // delete image
        if ($avatar_path) {
            unlink($avatar_path);
        }
    }

    // fetch all thumbnails of user's posts and delte them
    $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
    $thumbnail_result = mysqli_query($conn, $thumbnail_query);

    if (mysqli_num_rows($thumbnail_result) > 0) {
        while ($thumbnail = mysqli_fetch_assoc($thumbnail_result)) {
            $thumbnail_name = $thumbnail['thumbnail'];
            $thumbnail_path = '../images/' . $thumbnail_name;
            if ($thumbnail_path) {
                unlink($thumbnail_path);
            }
        }
    }

    $delete_query = "DELETE FROM users WHERE id = $id";
    $delete_query_result = mysqli_query($conn, $delete_query);

    if (mysqli_errno($conn)) {
        $_SESSION['delete-user'] = "Couldn't delete user";
    } else {
        $_SESSION['delete-user-success'] = "User '{$user['firstname']} {$user['lastname']}' deleted successfully";
    }
}

header('location:' . ROOT_URL . 'admin/manage_users.php');
