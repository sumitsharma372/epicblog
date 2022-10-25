<?php
include 'partials/header.php';
// fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE is_featured = 1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);


$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts_result = mysqli_query($conn, $query);

?>

<?php if (mysqli_num_rows($featured_result) == 1) : ?>
    <section class="featured">
        <div class="container featured_container">
            <div class="post_thumbnail">
                <img src="./images/<?= $featured['thumbnail'] ?>">
            </div>
            <div class="post_info">
                <?php
                // fetch category from categories table using category_id of post
                $category_id = $featured['category_id'];
                $category_sql = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($conn, $category_sql);
                $category = mysqli_fetch_assoc($category_result);

                $author_id = $featured['author_id'];
                $author_sql = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($conn, $author_sql);
                $author = mysqli_fetch_assoc($author_result);
                ?>

                <a href="<?= ROOT_URL ?>category_posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
                <h2 class="post_title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
                <p class="post_body">
                    <?= substr($featured['body'], 0, 300) ?>...
                </p>
                <div class="post_author">
                    <div class="post_author-avatar">
                        <img src="./images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post_author-info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small><?= date("F j,Y - g:i a", strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>

<!-- ----------Featured Post Finished------------- -->

<section class="posts <?= $featured ? '' : 'section_extra-margin' ?>">
    <div class="container posts_container">
        <?php while ($post = mysqli_fetch_assoc($posts_result)) : ?>
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

<?php
include 'partials/footer.php';
?>