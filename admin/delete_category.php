<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);


    // update categroy_id of posts that belong to this category to id of uncategorized category

    $update_query = "UPDATE posts SET category_id=8 WHERE category_id = $id";
    $update_result = mysqli_query($conn, $update_query);

    if (!mysqli_errno($conn)) {
        $sql = "DELETE FROM categories WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $_SESSION['delete-category-success'] = "Category deleted successfully!";
    }
} else {
    header('location:' . ROOT_URL . 'admin/manage_categories');
}

header('location:' . ROOT_URL . 'admin/manage_categories.php');
