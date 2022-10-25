<?php

include 'partials/header.php';
// fetch categories from the database
$sql = "SELECT * FROM categories ORDER BY title";
$result = mysqli_query($conn, $sql);
?>



<section class="dashboard">
    <?php if (isset($_SESSION['add-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category'])) : ?>
        <div class="alert_message error container">
            <p>
                <?php
                echo $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?php
                echo $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
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
                        <a href="manage_users.php">
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
                        <a href="manage_categories.php" class="active">
                            <i class="fa-solid fa-list"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($category = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit_category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete_category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert_message error">
                    <?= "No categories found" ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</section>





<?php
include '../partials/footer.php';
?>