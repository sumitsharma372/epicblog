<?php

include 'partials/header.php';
// fetch categories from database
if (isset($_GET['id'])) {
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location:' . ROOT_URL . 'admin/');
    die();
}
$category_sql = "SELECT * FROM categories";
$categories = mysqli_query($conn, $category_sql);

?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Post</h2>
        <form class="actions" action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $post['id'] ?> ">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?> ">
            <input type="text" name="title" value="<?= $post['title'] ?> " placeholder=" Title">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Description"><?= $post['body'] ?></textarea>
            <div class="form_control" style="display: flex; flex-direction: row;">
                <input type="checkbox" value="1" name="is_featured" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form_control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>