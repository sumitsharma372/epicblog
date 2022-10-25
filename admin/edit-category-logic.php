<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // check input
    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Invalid form input in edit category page!";
    } else {
        $sql = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_errno($conn)) {
            $_SESSION['edit-category'] = "Couldn't edit category!";
        } else {
            $_SESSION['edit-category-success'] = "Category updated!";
        }
    }
}

header('location:' . ROOT_URL . 'admin/manage_categories.php');
