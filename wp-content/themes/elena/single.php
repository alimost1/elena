<?php
/**
 * Elena Single Post Template
 *
 * @package Elena
 */

get_header();
?>

<div class="elena-page-content elena-section">
    <div class="elena-container elena-single-container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'elena-single-post' ); ?>>
                <header class="elena-single-header">
                    <h1 class="elena-page-title"><?php the_title(); ?></h1>
                    <div class="elena-single-meta">
                        <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                        <span class="elena-meta-sep">&middot;</span>
                        <span><?php the_author(); ?></span>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="elena-single-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
                <?php endif; ?>

                <div class="elena-entry-content">
                    <?php the_content(); ?>
                </div>

                <div class="elena-post-navigation">
                    <?php the_post_navigation( array(
                        'prev_text' => '&laquo; %title',
                        'next_text' => '%title &raquo;',
                    ) ); ?>
                </div>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</div>

<?php
get_footer();
