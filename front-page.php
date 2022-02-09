<?php get_header(); ?>
<div class="wrapper">
    <div style="background: gray; display: flex; justify-content: center">
        <img src="<?php bloginfo('template_url') ?>/dist/assets/images/logo.png">
    </div>
    <?php the_content()?>
</div>
<?php get_footer(); ?>