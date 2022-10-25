<?php

include 'partials/header.php';
// fetch users from database
$current_user_id = $_SESSION['user-id'];
$sql = "SELECT * FROM users WHERE NOT id = '$current_user_id'";
$result = mysqli_query($conn, $sql);
?>



<section class="dashboard">
    <!-- if user was added successfully -->
    <?php
    if (isset($_SESSION['add-user-success'])) :
    ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user'])) : ?>
        <div class="alert_message error container">
            <p>
                <?php
                echo $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user'])) : ?>
        <div class="alert_message error container">
            <p>
                <?php
                echo $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container dashboard_container">
        <button class="sidebar_toggle" id="show_sidebar-btn"><i class="fa-solid fa-chevron-right"></i></button>
        <button class="sidebar_toggle" id="hide_sidebar-btn"><i class="fa-solid fa-chevron-left"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add_post.php">
                        <i class="fa-solid fa-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="fa-regular fa-address-card"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php
                if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add_user.php">
                            <i class="fa-solid fa-user"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a class="active" href="manage_users.php">
                            <i class="fa-solid fa-users"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add_category.php">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage_categories.php">
                            <i class="fa-solid fa-list"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <?php
            if (mysqli_num_rows($result) > 0) :
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo "{$user['firstname']} {$user['lastname']}" ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit_user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete_user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                                <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endwhile ?>

                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert_message error">
                    <?= "No users found" ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</section>





<?php
include '../partials/footer.php';
?>