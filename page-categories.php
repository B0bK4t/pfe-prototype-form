<?php get_header(); ?>
<div class="wrapper exercices">
    <h1>Liste des catégories</h1>
    <div class="exercices-list">
        <?php
        query_posts(array(
            'post_type' => 'category',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'showposts' => -1,
        )); 
        if (have_posts()) :
        while (have_posts()) : the_post();
            echo "<div class='exercice'><section><h2>" . get_the_title() . "</h2>";
            if (get_the_post_thumbnail()):
                echo "<img src='" . get_the_post_thumbnail_url() . "'>";
            endif;
            echo "</section>" . "<a class='details' href='" . get_the_permalink() . "'>Détails</a></div>";
        endwhile;
    endif;
        ?>
    </div>
</div>
<?php get_footer(); ?>