<?php

include 'partials/header.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $is_admin = $user['is_admin'];
} else {
    header('location:' . ROOT_URL . 'admin/manage_users.php');
    die();
}
?>





<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit User</h2>
        <form class="actions" action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="<?= $user['id'] ?>" name="id">
            <input type="text" value="<?= $firstname ?>" name="firstname" placeholder="First Name">
            <input type="text" value="<?= $lastname ?>" name="lastname" placeholder="Last Name">
            <select name="userrole">
                <?php if ($is_admin == 0) : ?>
                    <option value="0" selected="selected">Author</option>
                    <option value="1">Admin</option>
                <?php else : ?>
                    <option value="0">Author</option>
                    <option value="1" selected="selected">Admin</option>
                <?php endif ?>
            </select>
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>