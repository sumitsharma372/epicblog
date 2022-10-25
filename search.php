<?php
require 'partials/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sql = "SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC";
    $posts = mysqli_query($conn, $sql);
} else {
    header('location:' . ROOT_URL . 'blog.php');
    die();
}

?>

<section class="posts section_extra-margin" style="margin-top: 7rem;">

    <?php if (mysqli_num_rows($posts) > 0) : ?>
        <div class="container posts_container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <?php
                $category_id = $post['category_id'];
                $category_sql = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($conn, $category_sql);
                $category = mysqli_fetch_assoc($category_result);

                $author_id = $post['author_id'];
                $author_sql = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($conn, $author_sql);
                $author = mysqli_fetch_assoc($author_result);
                ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>">
                    </div>
                    <div class="post_info">
                        <a href="<?= ROOT_URL ?>category_posts.php?id=<?= $category_id ?>" class="category_button"><?= $category['title'] ?></a>
                        <h3 class="post_title">
                            <a href="<?= ROOT_URL ?>post.php?<?= $post['id'] ?>">
                                <?= $post['title'] ?>
                            </a>
                        </h3>
                        <p class="post_body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post_author">
                            <div class="post_author-avatar">
                                <img src="./images/<?= $author['avatar'] ?>">
                            </div>
                            <div class="post_author-info">
                                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small><?= date("F m,Y - g:i a", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>

                    </div>
                </article>
            <?php endwhile ?>
        </div>
    <?php else : ?>
        <div class="alert_message error container" style="text-align:center;">
            <?= "No search results found" ?>
        </div>
    <?php endif ?>
</section>


<section class="category_buttons">
    <div class="container category_container">
        <?php
        $category_query = "SELECT * FROM categories ORDER BY title";
        $category_query_result = mysqli_query($conn, $category_query);
        ?>
        <?php while ($category = mysqli_fetch_assoc($category_query_result)) : ?>
            <a href="<?= ROOT_URL ?>category_posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>


<?php
include 'partials/footer.php';
?>