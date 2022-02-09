<?php get_header(); 

//FORM ---------------
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty($_POST['post_id']) && ! empty($_POST['post_title']) && isset($_POST['update_post_nonce']) && isset($_POST['postcontent']) )
{
    $post_id   = $_POST['post_id'];
    $post_type = get_post_type($post_id);
    $capability = ( 'page' == $post_type ) ? 'edit_page' : 'edit_post';
    if ( current_user_can($capability, $post_id) && wp_verify_nonce( $_POST['update_post_nonce'], 'update_post_'. $post_id ) )
    {
        $post = array(
            'ID'             => esc_sql($post_id),
            'post_content'   => esc_sql($_POST['postcontent']),
            'post_title'     => esc_sql($_POST['post_title'])
        );
        $updatedPostID = wp_update_post($post);

        //Image
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        $attachment_id = media_handle_upload( 'img', 55 );
       
        set_post_thumbnail($updatedPostID, $attachment_id);

        if ( isset($_POST['materiel']) ) update_post_meta($post_id, 'materiel', esc_sql($_POST['materiel']) );
        if ( isset($_POST['origin']) ) update_post_meta($post_id, 'origin', esc_sql($_POST['origin']) );

        header("Location:" . $_SERVER['REQUEST_URI']);
    }
    else
    {
        wp_die("You can't do that");
    }
}

$images = array();
?>

<div class="wrapper single-exercice" data-component="Categories">
    <form id="post" class="single-form " method="post" enctype="multipart/form-data" data-component="singleForm">
        <p class="retour"><a href="<?php blogInfo('url');?>/exercices">Retour à la banque d'exercices</a></p>
        <h1 class="toHide"><?php the_title(); ?></h1>
        <h1><input type="text" id="post_title" name="post_title" value="<?php echo $post->post_title; ?>" /></h1>
        <?php if(get_field('categories')):?>
        <small class="toHide originalCats" id="smol" style="max-width: 78%">
            Catégories: <?php foreach((get_field('categories')) as $category) {
            echo "<a href='" . get_the_permalink($category->ID) . "'>" . get_the_title($category->ID) . '</a>; ';
        }?></small>
        <?php endif;?>
        <img src="<?php the_post_thumbnail_url()?>">
        <h3 class="inputEquivalent">Changer l'image:</h3>
        <h4 class="h4">Mettre en ligne une nouvelle image:</h4>
        <input type="file" id="img" name="img" accept="image/*"></input>
        <!-- <article class="image-gallery inputEquivalent">
            <h4 class="h4">Images déjà existantes:</h4>
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'orderby' => 'post_date',
                'order' => 'desc',
                'posts_per_page' => '-1',
                'post_status'    => 'inherit',
            ));

            $i = 0;

            while ( $loop->have_posts() ) : $loop->the_post();

            $id = wp_get_attachment_image_src( get_the_ID() ); 
            echo "<div class='item'>
            <img src='" . $id[0] . "'>" ?>
            <svg class="icon action icon--lg">
                <use xlink:href="#icon-bin"></use>
            </svg>
            <div class="select">
                <input type="radio" name="selected[]" id="selected <?php echo $i;?>">
            </div>
            <?php echo
            "</div>";
            $i++;
            endwhile;
            wp_reset_query();
            ?>
        </article> -->
        <?php $content = get_post()->post_content;
            if(empty($content)):
                echo "<div style='width: 75%'><h3 class='inputEquivalent'>Description: </h3>";
                echo wp_editor( $post->post_content, 'postcontent', array( 
                    'media_buttons' => false, 
                    'default_editor' => 'Quicktags', 
                ));
                echo "</div>";
            else:
            ?>
        <div class="desc">
            <h3>Description:</h3>
            <div class="toHide"><?php the_content(); ?></div>
            <?php wp_editor( $post->post_content, 'postcontent', array( 
                'media_buttons' => false, 
                'default_editor' => 'Quicktags', 
            )); ?>
        </div>
        <?php endif;?>
        <?php if (get_field('prerequis')):?>
        <div>
            <h3>Instructions</h3>
            <?php foreach((get_field('prerequis')) as $p) {
            echo "<a href='" . get_the_permalink($p->ID) . "'>" . get_the_title($p->ID) . '</a><br />';
        }?>
        </div>
        <?php endif;?>
        <?php if (get_field('materiel')):?>
        <h3 class="origine">Matériel requis:</h3>
        <p class="toHide"><?php the_field('materiel')?></p>
        <?php else: ?>
        <h3 class="inputEquivalent origine">Matériel requis:</h3>
        <?php endif ?>
        <p><?php $value = get_post_meta(get_the_ID(), 'materiel', true); ?>
            <input type="text" id="materiel" name="materiel" value="<?php echo $value; ?>">
        </p>
        <?php if (get_field('origine')):?>
        <h3 class="toHide origine">Origine: <?php the_field('origine')?>
        </h3>
        <?php endif ?>
        <h3 class="inputEquivalent origine"> Origine: <?php $value = get_post_meta(get_the_ID(), 'origine', true); ?>
            <input type="text" id="origine" name="origine" value="<?php echo $value; ?>">
        </h3>

        <input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
        <?php wp_nonce_field( 'update_post_'. get_the_ID(), 'update_post_nonce' ); ?>
        <input type="submit" id="submit" value="Mettre à jour" />
        <div class="plus edit">
            <svg class="icon icon--xl">
                <use xlink:href="#icon-edit"></use>
            </svg>
        </div>
        <div class="plus close">
            <svg class="icon icon--xl">
                <use xlink:href="#icon-close"></use>
            </svg>
        </div>
    </form>
</div>

<?php get_footer(); ?>