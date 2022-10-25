    <footer>
        <div class="links">
            <a href="https://twitter.com/SumitSh89693082"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.facebook.com/profile.php?id=100035109126896"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com/sumit__sharma72/"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://github.com/sumitsharma372"><i class="fa-brands fa-github"></i></a>
            <a href="https://www.linkedin.com/in/sumit-sharma-b8a396227/"><i class="fa-brands fa-linkedin"></i></a>
        </div>
        <div class="container footer_container">
            <article>
                <h4>Categories</h4>
                <ul>
                    <?php
                    $category_query = "SELECT * FROM categories ORDER BY title";
                    $category_query_result = mysqli_query($conn, $category_query);
                    ?>
                    <?php while ($category = mysqli_fetch_assoc($category_query_result)) : ?>

                        <li><a href="<?= ROOT_URL ?>category_posts.php?id=<?= $category['id'] ?>"><?= $category['title'] ?></a></li>
                    <?php endwhile ?>
                </ul>
            </article>
            <article>
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Online Support</a></li>
                    <li><a href="#">Call Numbers</a></li>
                    <li><a href="#">Emails</a></li>
                    <li><a href="#">Social Support</a></li>
                    <li><a href="#">Location</a></li>

                </ul>
            </article>
            <article>
                <h4>Blog</h4>
                <ul>
                    <li><a href="#">Safety</a></li>
                    <li><a href="#">Repair</a></li>
                    <li><a href="#">Popular</a></li>
                    <li><a href="#">Categories</a></li>
                </ul>
            </article>
            <article>
                <h4>Permalinks</h4>
                <ul>
                    <li><a href="<?= ROOT_URL ?>">Home</a></li>
                    <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                    <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                    <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                    <li><a href="<?= ROOT_URL ?>contacts.php">Contacts</a></li>
                </ul>
            </article>
        </div>
        <div class="footer_copyright">
            <small>Copyright &copy; EPICBLOG 2022</small>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/79129b46ef.js" crossorigin="anonymous"></script>
    <script src="<?= ROOT_URL ?>js/main.js"></script>
    </body>

    </html>