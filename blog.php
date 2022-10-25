<?php
include 'partials/header.php';
$sql = "SELECT * FROM posts ORDER BY title";
$posts = mysqli_query($conn, $sql);

?>

<section class="search_bar">
    <form class="container search_container" action="<?= ROOT_URL ?>search.php" method="GET">
        <div>
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" name="submit" class="btn">Go</button>
    </form>
</section>


<section class="posts">
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
                    <img src="./images/<?= $post['thumbnail'] ?>?">
                </div>
                <div class="post_info">
                    <a href="<?= ROOT_URL ?>category_posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
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
                            <small><?= date("F m, Y - g:i a", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>

                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>


<?php
include 'partials/footer.php';
?>