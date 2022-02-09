<?php get_header(); ?>

<?php
//FORM ---------------
    if ( isset($_POST['title']) ) {
        
        // Vérifier validité
        if( wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
            
           // Contenu

            $post = array(
                'post_title'        => $_POST['title'],
                // 'post_content'      => $_POST['content'],
                'post_status'       => 'publish',
                'post_type' 	    => 'category',
            );
            $postID = wp_insert_post($post);
            
            // header("Location: " . get_bloginfo('url') . "/" .  $url);
            echo "Catégorie ajoutée. <a href=" . site_url() . "/creer-une-categorie/\">Recharger la page</a>";
        } 
    }
    
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') { 
        $protocol = "https://";
    }
    else {
        $protocol = "http://";
    }
    $rURL = $_SERVER['REQUEST_URI'];
    $rURL = str_replace('/pfe/','',$rURL);
    $title = stripslashes(urldecode($_REQUEST['title']));
?>
<div class="wrapper">
    <h1>La catégorie <?php $title?> a bien été créée.</h1>
</div>
<!-- <article data-component="CachedForm" data-step="Landing">
    <div class="wrapper creer-ex">
        <h1 style="margin: 15px; font-size: 2rem">Créer une catégorie</h1>
        <div id="postbox">
            <form id="new_post" name="new_post" method="post" enctype="multipart/form-data">

                <p><label for="title">Nom de la catégorie</label><br />
                    <input type="text" id="title" value="" size="20" name="title" required="true" />
                </p>

                <?php 
                 query_posts(array(
                    'post_type' => 'category',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Catégories déjà existantes:</label>";
                while (have_posts()) : the_post();
                    echo "<div>" . get_the_title() ."</div>";
                endwhile;
                    echo "</div>";
                endif;

            ?>

                <?php wp_nonce_field( 'wps-frontend-post' ); ?>

                <p class="submit"><input type="submit" value="Ajouter" id="submit" name="submit" /></p>
                <input hidden id="protocol" value="<?php echo $protocol;?>">
                <input hidden id="url" value="<?php echo site_url() . "/" . $rURL?>">
            </form>
            <div><a class="button" id="button" href="<?php bloginfo('url')?>/exercices">Aller à la banque
                    d'exercices</a></div>
        </div>
    </div>
</article> -->
<?php get_footer(); ?>