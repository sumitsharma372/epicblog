<?php

include 'partials/header.php';
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
// $is_admin = $_SESSION['add-user-data']['userrole'];
unset($_SESSION['add-user-data']);

?>





<section class="form_section">
    <div class="container form_section-container">
        <h2>Add User</h2>
        <?php
        if (isset($_SESSION['add-user'])) :
        ?>
            <div class="alert_message error">
                <p><?= $_SESSION['add-user'];
                    unset($_SESSION['add-user']); ?></p>
            </div>
        <?php endif ?>
        <form class="actions" action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" value="<?= $firstname ?>" name="firstname" placeholder="First Name">
            <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname ?>">
            <input type="text" name="username" placeholder="Username" value="<?= $username ?>">
            <input type="email" name="email" placeholder="Email" value="<?= $email ?>">
            <input type="password" name="createpassword" placeholder="Create  Password">
            <input type="password" name="confirmpassword" placeholder="Confirm Password">
            <select name="userrole">
                <option value="0" selected="selected">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Add User</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>