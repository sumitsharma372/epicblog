<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    if (!$firstname) {
        $_SESSION['signup'] = 'Please enter your first name!';
    } elseif (!$lastname) {
        $_SESSION['signup'] = 'Please enter your last name!';
    } elseif (!$username) {
        $_SESSION['signup'] = 'Please enter your username!';
    } elseif (!$email) {
        $_SESSION['signup'] = 'Please enter your a valid email!';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = 'Password should have at least 8 characters!';
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = 'Please add an image!';
    } else {
        if ($createpassword != $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in database

            $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['signup'] = "Username or email already exists!";
            } else {
                // work on avatar
                // rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

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
                        $_SESSION['signup'] = "File size too big. Should be less than 10mb!";
                    }
                } else {
                    $_SESSION['signup'] = "File should be png, jpg, jpeg, webp";
                }
            }
        }
    }

    if (isset($_SESSION['signup'])) {
        // pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into users table
        $add_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email','$hashed_password', '$avatar_name',0)";

        $add_user_result = mysqli_query($conn, $add_user_query);

        if (!mysqli_errno($conn)) {
            // redirect to login page with success page
            $_SESSION['signup-success'] = "Signup successful. Please login!";
            header('location:' . ROOT_URL . 'signin.php');
            die();
        }
    }
} else {
    // if button is not clicked bounce back to signup page
    header('location:' . ROOT_URL . 'signup.php');
    die();
}
