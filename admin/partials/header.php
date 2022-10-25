<?php
require '../partials/header.php';


// lets check status

if (!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
}
