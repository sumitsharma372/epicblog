<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    if (!$firstname) {
        $_SESSION['add-user'] = 'Please enter your first name!';
    } elseif (!$lastname) {
        $_SESSION['add-user'] = 'Please enter your last name!';
    } elseif (!$username) {
        $_SESSION['add-user'] = 'Please enter your username!';
    } elseif (!$email) {
        $_SESSION['add-user'] = 'Please enter your a valid email!';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = 'Password should have at least 8 characters!';
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = 'Please add an image!';
    } else {
        if ($createpassword != $confirmpassword) {
            $_SESSION['add-user'] = "Passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in database

            $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['add-user'] = "Username or email already exists!";
            } else {
                // work on avatar
                // rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['png', 'jpeg', 'jpg', 'webp'];
                $extension_arr = explode('.', $avatar_name);
                $extension = end($extension_arr);

                if (in_array($extension, $allowed_files)) {
                    // make sure image is not too large
                    if ($avatar['size'] < 10000000) {
                        // upload avatar
                        move_uploaded_file($avatar_temp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "File size too big. Should be less than 10mb!";
                    }
                } else {
                    $_SESSION['add-user'] = "File should be png, jpg, jpeg, webp";
                }
            }
        }
    }

    if (isset($_SESSION['add-user'])) {
        // pass form data back to signup page
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_user.php');
        die();
    } else {
        // insert new user into users table
        $add_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email','$hashed_password', '$avatar_name','$is_admin')";

        $add_user_result = mysqli_query($conn, $add_user_query);

        if (!mysqli_errno($conn)) {
            // redirect to login page with success page
            $_SESSION['add-user-success'] = "User added successfully.";
            header('location:' . ROOT_URL . 'admin/manage_users.php');
            die();
        }
    }
} else {
    // if button is not clicked bounce back to signup page
    header('location:' . ROOT_URL . 'admin/add_user.php');
    die();
}
