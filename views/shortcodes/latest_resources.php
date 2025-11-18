<?php if ( ! $query->have_posts() ): ?>
    <div>No Posts Found.</div>
<?php else: ?>
<section class="grid">
<?php while( $query->have_posts() ): $query->the_post(); ?>
    <div class="grid__item">
        <div class="grid__item-media">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium_large', [
                    'class' => 'grid__item-image'
                ]);
            else: ?>
                <div class="grid__item-image-placeholder"></div>
            <?php endif; ?>
        </div>
        <h2 class="grid__item-title"><?php the_title(); ?></h2>
        <div class="grid__item-excerpt"><?php the_excerpt(); ?></div>
        <a href="<?php the_permalink(); ?>" class="grid__item-link">Read More</a>
    </div>
<?php endwhile; wp_reset_postdata(); ?>
</section>
<?php endif; ?>
