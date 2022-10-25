<?php
include 'partials/header.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    $author_id = $post['author_id'];
    $author_sql = "SELECT * FROM users WHERE id = $author_id";
    $author_result = mysqli_query($conn, $author_sql);
    $author = mysqli_fetch_assoc($author_result);
}
?>


<section class="singlepost">
    <div class="container singlepost_container">
        <h2><?= $post['title'] ?></h2>
        <div class="post_author">
            <div class="post_author-avatar">
                <img src="./images/<?= $author['avatar'] ?>">
            </div>
            <div class="post_author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("F m,Y - g:i a", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost_thumbnail">
            <img src="./images/<?= $post['thumbnail'] ?>">
        </div>
        <p>
            <?= $post['body'] ?>
        </p>

    </div>

    </div>
</section>



<?php
include 'partials/footer.php';
?>