<?php get_header(); ?>
<?php 
/* Template Name: Créer Exercice */
?>
<?php
//FORM ---------------
    if ( isset($_POST['title']) ) {
        
        // Vérifier validité
        if( wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
            
           // Contenu

            $post = array(
                'post_title'        => $_POST['title'],
                'post_content'      => $_POST['content'],
                'post_status'       => 'publish',
                'post_type' 	    => 'exercice',
            );
            $postID = wp_insert_post($post);

            //Modifier les ACFs
            update_field('field_61f2de0651203', $_POST['origin'], $postID); //Origine
            update_field('field_61f30486013cb', $_POST['mat'], $postID); //Matériel
            update_field('field_61fa919267c31', $_POST['cat'], $postID); //Catégories
            update_field('field_61fa9ad41a28b', $_POST['pr'], $postID); //Pré-requis

            //Image
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
            $attachment_id = media_handle_upload( 'img', 55 );
           
            set_post_thumbnail($postID, $attachment_id);
            
            // header("Location: " . get_bloginfo('url') . "/" .  $url);
            echo "
            <aside class='notif' data-component='Notif'>
                <div class='bg'>
                    <h3>Exercice \"" . $_POST['title'] . "\" ajouté.</h3>
                    <div class='close'>
                        <svg class='icon icon--lg'>
                            <use xlink:href='#icon-close'></use>
                        </svg>
                    </div>
                </div>
            </aside>";
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
    $desc = stripslashes(urldecode($_REQUEST['content']));
    $catURL = stripslashes(urldecode($_REQUEST['cats']));
    $cats = explode("," , $catURL);
    foreach ($cats as $cat) {
        echo "<span class='hideThis js-cat'>". $cat . "</span>";
    }
    $origin = stripslashes(urldecode($_REQUEST['origin']));
    $materiel = stripslashes(urldecode($_REQUEST['mat']));
?>

<article data-component="CachedForm" data-id="creer" data-step="Origin">
    <div class="wrapper creer-ex">
        <p class="retour"><a href="<?php blogInfo('url');?>/exercices">Retour à la banque d'exercices</a></p>
        <h1 style="font-size: 2.5rem">Créer un exercice</h1>
        <div id="postbox">
            <form class="form" id="new_post" name="new_post" method="post" enctype="multipart/form-data">

                <p><label for="title">Nom de l'exercice</label>
                    <input type="text" id="title" value="<?php echo $title?>" size="20" name="title" required="true" />
                </p>

                <p>
                    <label for="content">Description de l'exercice</label>

                    <textarea id="content" name="content" cols="40" rows="6"><?php echo $desc?></textarea>
                </p>

                <input hidden id="protocol" value="<?php echo $protocol;?>">
                <input hidden id="url" value="<?php echo site_url() . "/" . $rURL?>">

                <section class="cats">
                    <?php
                 query_posts(array(
                    'post_type' => 'category',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Catégories:</label><div>";
                    $i = 0;
                while (have_posts()) : the_post();
                    echo "<div><input class='catcheck' type='checkbox' data-name='" . get_the_title() . "' name='cat[]' id='cat" . $i . "' value='" . get_the_id() . "'><label for='cat" . $i . "'>" . get_the_title() ."</label></div>";
                    $i++;
                endwhile;
                    echo "</div><a class='button js-click' href='" . get_bloginfo('url') . "/creer-une-categorie'>Ajouter une catégorie</a></div>";
                endif;
                query_posts(array(
                    'post_type' => 'prerequi',
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'post_status' => 'publish',
                    'showposts' => -1,
                )); 
                if (have_posts()) :
                    echo "<div class='checks'><label>Prérequis:</label><div>";
                    $i = 0;
                while (have_posts()) : the_post();
                    echo "<div><input class='prechecks' type='checkbox' data-name='" . get_the_title() . "' name='pr[]' id='pr" . $i . "' value='" . get_the_id() . "'><label for='pr" . $i . "'>" . get_the_title() ."</label></div>";
                    $i++;
                endwhile;
                    echo "</div><a class='button js-click' href='" . get_bloginfo('url') . "/creer-un-prerequis'>Ajouter un prérequis</a></div>";
                endif;
            ?>
                </section>

                <p><label for="origin">Origine</label>

                    <input type="text" id="origin" value="<?php echo $origin?>" size="20" name="origin" />
                </p>

                <p>
                    <label for="mat">Matériel</label>

                    <textarea id="mat" name="mat" cols="40" rows="6"><?php echo $materiel?></textarea>
                </p>

                <p class="img">
                    <label for="img">Image</label>

                    <input type="file" id="img" name="img" accept="image/*"></input>
                </p>

                <?php wp_nonce_field( 'wps-frontend-post' ); ?>
                <p class="submit"><input type="submit" value="Ajouter" id="submit" name="submit" /></p>
            </form>
        </div>
    </div>
    <?php get_footer(); ?>
    <script>
    let cats = document.querySelectorAll('.js-cat');
    let inputs = document.querySelectorAll('.catcheck');
    let inputs2 = document.querySelectorAll('.prechecks');

    for (let i = 0; i < cats.length; i++) {
        const c = cats[i];
    }

    for (let i = 0; i < cats.length; i++) {
        let c = cats[i];
        c = c.innerHTML;
        c = c.replaceAll('_', ' ');
        c = c.replaceAll('|', ',');

        for (let ii = 0; ii < inputs.length; ii++) {
            const p = inputs[ii];
            if (p.dataset.name == c) {
                p.setAttribute('checked', true);
            }
        }
        for (let ii = 0; ii < inputs2.length; ii++) {
            const p = inputs2[ii];
            if (p.dataset.name == c) {
                p.setAttribute('checked', true);
            }
        }
    }
    </script>
</article>