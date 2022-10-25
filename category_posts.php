<?php
include 'partials/header.php';
if (isset($_GET['id'])) {
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM posts WHERE category_id = $category_id";
    $posts = mysqli_query($conn, $sql);

    $category_sql = "SELECT * FROM categories WHERE id = $category_id";
    $category_result = mysqli_query($conn, $category_sql);
    $category = mysqli_fetch_assoc($category_result);
}
?>


<header class="category_title">
    <h2><?= $category['title'] ?></h2>
</header>




<section class="posts">
    <?php if (mysqli_num_rows($posts) > 0) : ?>
        <div class="container posts_container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <?php
                $author_id = $post['author_id'];
                $author_sql = "SELECT * FROM users WHERE id = $author_id";
                $author_result = mysqli_query($conn, $author_sql);
                $author = mysqli_fetch_assoc($author_result);
                ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>">
                    </div>
                    <div class="post_info">
                        <!-- <a href="" class="category_button">Programming</a> -->
                        <h3 class="post_title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
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
        <div class="alert_message container error" style="text-align:center">
            <?= "No posts found related to above category!" ?>
        </div>
    <?php endif ?>
</section>


<!-- -----------------------------------
        END OF POSTS
    ---------------------------------------->
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


<!-- ---------------------------------------
                FOOTER
    ------------------------------------------->

<?php
include 'partials/footer.php';
?>