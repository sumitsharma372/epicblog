<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['add-category'] = "Enter Title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter Description";
    }

    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_category.php');
        die();
    } else {
        $sql = "INSERT INTO categories (title, description) VALUES ('$title','$description')";
        $result = mysqli_query($conn, $sql);
        if (mysqli_errno($conn)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location:' . ROOT_URL . 'admin/add_category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "Category added successfully";
            header('location:' . ROOT_URL . 'admin/manage_categories.php');
            die();
        }
    }
}
