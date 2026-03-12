<?php
/**
 * Elena Page Template
 *
 * @package Elena
 */

get_header();
?>

<div class="elena-page-content elena-section">
    <div class="elena-container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="elena-page-title"><?php the_title(); ?></h1>
                <div class="elena-entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php
get_footer();
