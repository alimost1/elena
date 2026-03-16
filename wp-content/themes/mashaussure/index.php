<?php
/**
 * Elena Index/Fallback Template
 *
 * @package Elena
 */

get_header();
?>

<div class="elena-page-content elena-section">
    <div class="elena-container">
        <?php if ( have_posts() ) : ?>
            <div class="elena-posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'elena-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="elena-post-thumb">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="elena-post-body">
                            <h2 class="elena-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="elena-post-excerpt"><?php the_excerpt(); ?></div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="elena-pagination">
                <?php the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                ) ); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'elena' ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
