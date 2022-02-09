<?php get_header(); ?>
<div class="wrapper single-exercice">
    <p class="retour"><a href="<?php blogInfo('url');?>/categories">Retour à la liste des catégories</a>
    <h1><?php the_title(); ?></h1>
    <h3>Exercices dans la catégorie "<?php the_title()?>":</h3>
    <?php $exercices = get_posts(array(
            'post_type' => 'exercice',
            'meta_query' => array(
                array(
                    'key' => 'categories',
                    'value' => '"' . get_the_ID() . '"',
                    'compare' => 'LIKE'
                )
                ),
                'orderby' => 'title',
                'order' => 'ASC',
                'showposts' => -1,
        ));?>
    <?php if($exercices):?>
    <div class="exercice-list">
        <?php foreach($exercices as $e):
            echo "<div class='exercice' style='border: 1px solid black'><section><h2>" . get_the_title($e->ID) . "</h2>";
            if (get_the_post_thumbnail($e->ID)):
                echo "<img src='" . get_the_post_thumbnail_url($e->ID) . "'>";
            endif;
            echo "</section>" . "<a class='details' href='" . get_the_permalink($e->ID) . "'>Détails</a></div>";
        endforeach;?>
    </div>
    <?php endif;?>
</div>
<?php get_footer(); ?>