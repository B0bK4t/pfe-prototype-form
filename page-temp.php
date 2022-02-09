<?php get_header(); ?>
<div class="wrapper">
    <?php 
         query_posts(array(
            'post_type' => 'temp',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'showposts' => -1,
        ));?>
    <?php if (have_posts()) :
            while (have_posts()) : the_post();?>
    <article style="border: 5px solid var(--color-primary); padding: 5px;">
        <h1><?php the_title()?></h1>
        <small id="smol" style="max-width: 78%">
            Catégories: <?php if (get_field('categories')):?>
            <?php $posts = get_field('categories');
            foreach($posts as $p):
                echo get_the_title($p->ID) . ";";
            endforeach;
            ?>
            <?php endif;?>
        </small>
        <img style="max-width: 116px; float: right" src="<?php the_post_thumbnail_url()?>">
        <?php $content = get_post()->post_content;
    if(empty($content)): //Do nothing
    else:
    ?>
        <div class="desc">
            <h3>Description:</h3>
            <?php the_content(); ?>
        </div>
        <?php endif;?>
        <div>
            <?php if (get_field('prerequis')):?>
            <h2>Pré-requis:</h2>
            <?php $posts = get_field('prerequis');
            foreach($posts as $p):
                echo get_the_title($p->ID) . "<br>";
            endforeach;
            ?>
            <?php endif;?>
        </div>
        <?php if (get_field('materiel')):?>
        <h3 class="origine">Matériel requis:</h3>
        <p><?php the_field('materiel')?></p>
        <?php endif ?>
        <?php if (get_field('origine')):?>
        <h3 class="origine">Origine: <?php the_field('origine')?>
        </h3>
        <?php endif ?>
    </article>
    <?php endwhile; endif;?>
</div>
<?php get_footer(); ?>