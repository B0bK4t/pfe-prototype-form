<?php get_header(); ?>
<div class="wrapper exercices">
    <h1>Liste des cartes de soin</h1>
    <?php
    query_posts(array(
        'post_type' => 'video',
        'order' => 'ASC',
        'orderby' => 'title',
        'post_status' => 'publish',
        'showposts' => -1,
    )); 
    if (have_posts()):
        echo "<div class='exercices-list'>";
        while (have_posts()): the_post();
        echo "<div class='exercice filtered'><section><h2>" . get_the_title() . "</h2>";
        if (get_the_post_thumbnail()):
            echo "<img src='" . get_field('image') . "'>";
        endif;
        echo "</section>" . "<a class='details' href='" . get_the_permalink() . "'>Détails</a></div>";
    endwhile;
    echo "</div>";
    endif;
    ?>
</div>
<?php get_footer(); ?>