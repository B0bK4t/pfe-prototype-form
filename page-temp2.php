<?php get_header(); ?>
<div class="wrapper">
    <?php 
         query_posts(array(
            'post_type' => 'temp2_cat',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'showposts' => -1,
        ));?>
    <?php if (have_posts()) :
            while (have_posts()) : the_post();?>
    <h1><?php the_title();?></h1>
    <?php endwhile; endif;?>
</div>
<?php get_footer(); ?>