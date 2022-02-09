<?php
get_header();
$url = 'categorie-creee';

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') { 
        $protocol = "https://";
    }
    else {
        $protocol = "http://";
    }
    $rURL = $_SERVER['REQUEST_URI'];
    $rURL = str_replace('/pfe/','',$rURL);


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
            
            // header("Location: " . get_bloginfo('url') . "/" .  $url . "/?name=" . $_POST['title']);
            echo "
            <aside class='notif' data-component='Notif'>
                <div class='bg'>
                    <h3>Prérequis \"" . $_POST['title'] . "\" ajouté.</h3>
                    <div class='close'>
                        <svg class='icon icon--lg'>
                            <use xlink:href='#icon-close'></use>
                        </svg>
                    </div>
                </div>
            </aside>";
        } 
    }

?>

<article data-component="CachedForm" data-id="creer" data-step="Target">
    <div class="wrapper creer-ex creer-cat">
        <h1 style="margin: 15px; font-size: 2rem">Créer un prérequis</h1>
        <div id="postbox">
            <form class="form" id="new_post" name="new_post" method="post" enctype="multipart/form-data">

                <p><label for="title">Nom du prérequis</label><br />
                    <input type="text" id="title" value="" size="20" name="title" required="true" />
                </p>

                <?php 
                 query_posts(array(
                    'post_type' => 'prerequi',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Prérequis déjà existants:</label><div>";
                while (have_posts()) : the_post();
                    echo "<div>" . get_the_title() ."</div>";
                endwhile;
                    echo "</div></div>";
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
</article>
<?php get_footer(); ?>