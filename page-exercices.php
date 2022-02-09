<?php get_header(); ?>
<?php 
/* Template Name: Exercices */
 ?>
<div class="wrapper exercices" data-component="Filter">
    <h1>Banque d'exercices</h1>
    <input class=" search-bar" placeholder="Trouver un exercice"></input>
    <div class="filtres-wrapper" data-component="Hide">
        <div class="inputs">
            <button id="filter"><span id="message">Afficher</span> filtres</button>
            <button id="reset">Réinitialiser</button>
        </div>
        <section class="filtres" data-filter="true">
            <form>
                <?php 
                 query_posts(array(
                    'post_type' => 'category',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Catégories</label>";
                    $i = 0;
                while (have_posts()) : the_post();
                    echo "<div class='js-clickable'><input type='checkbox' name='cat[]' id='cat" . $i . "' value='" . get_the_title() . "'><label for='cat" . $i . "'>" . get_the_title() ."</label></div>";
                    $i++;
                endwhile;
                    echo "</div>";
                endif;
                
                query_posts(array(
                    'post_type' => 'prerequi',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Pré-requis:</label>";
                    $i = 0;
                while (have_posts()) : the_post();
                    echo "<div class='js-clickable'><input type='checkbox' name='pr[]' id='pr" . $i . "' value='" . get_the_title() . "'><label for='pr" . $i . "'>" . get_the_title() ."</label></div>";
                    $i++;
                endwhile;
                    echo "</div>";
                endif;
            ?>
            </form>
        </section>
    </div>
    <?php wp_reset_query()?>
    <div class="exercices-list">
        <?php
        query_posts(array(
            'post_type' => 'exercice',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'showposts' => -1,
        )); 
        if (have_posts()) :
        while (have_posts()) : the_post();
            echo "<div class='exercice filtered' data-cat='"; 
            if (have_rows('categories')):
                $posts = get_field('categories');
                foreach ( $posts as $p):
                    $t = get_the_title($p->ID);
                    $t = str_replace(";", ',', $t);
                    echo $t . ";";
                endforeach;
            endif;
            if (have_rows('prerequis')):
                $posts = get_field('prerequis');
                foreach ( $posts as $p):
                    $t = get_the_title($p->ID);
                    $t = str_replace(";", ',', $t);
                    echo $t . ";";
                endforeach;
            endif;
            echo "'><section><h2>" . get_the_title() . "</h2>";
            if (get_the_post_thumbnail()):
                echo "<img src='" . get_the_post_thumbnail_url() . "'>";
            endif;
            echo "</section>" . "<a class='details' href='" . get_the_permalink() . "'>Détails</a></div>";
        endwhile;
    endif;
        ?>
    </div>
</div>
<a class="plus" href="<?php blogInfo('url');?>/creer-un-exercice">
    <img src="<?php bloginfo('template_url') ?>/dist/assets/images/plus.svg">
</a>
<?php get_footer(); ?>