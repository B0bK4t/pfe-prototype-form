<?php get_header(); 
//FORM ---------------
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty($_POST['post_id']) && ! empty($_POST['post_title']) && isset($_POST['update_post_nonce']) )
{
    $send = true;
    $post_id   = $_POST['post_id'];
    $post_type = get_post_type($post_id);
    $capability = ( 'page' == $post_type ) ? 'edit_page' : 'edit_post';
    if ( current_user_can($capability, $post_id) && wp_verify_nonce( $_POST['update_post_nonce'], 'update_post_'. $post_id ) && $send )
    {
        $post = array(
            'ID'             => esc_sql($post_id),
            'post_title'     => esc_sql($_POST['post_title'])
        );
        $updatedPostID = wp_update_post($post);

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        $attachment_id = media_handle_upload( 'img', 55 );

        set_post_thumbnail($updatedPostID, $attachment_id);

        $videoURL = $_POST['video_id'];
        $videoURL = str_replace("https://", "", $videoURL);
        $videoURL = str_replace("www.", "" ,$videoURL);
        $videoURL = str_replace("youtube.com/", "" ,$videoURL);
        $videoURL = str_replace("youtu.be/", "" ,$videoURL);
        $videoURL = str_replace("watch?v=", "" ,$videoURL);

        update_field('field_620275b8ebd73', $videoURL, $postID); //url vidéo
        header("Location:" . $_SERVER['REQUEST_URI']);
    }
    else
    {
    //    echo $videoURL;
        // wp_die("You can't do that");
    }
}

?>

<div class="wrapper video-single">
    <form id="post" class="single-form " method="post" enctype="multipart/form-data" data-component="singleForm">
        <h1 class="toHide" style="text-align: center"><?php the_title()?></h1>
        <h1><input type="text" id="post_title" name="post_title" value="<?php echo $post->post_title; ?>" /></h1>
        <section>
            <div data-component="Print" style="display: flex; flex-direction: column; align-items: center">
                <h2>Carte de soin</h2>
                <img id="carte" style="max-width: 100%" src="<?php the_post_thumbnail_url()?>">
                <h3 class="inputEquivalent">Changer l'image:</h3>
                <input type="file" id="img" name="img" accept="image/*"></input>
                <!-- <div class="button" style="padding: 5px">Imprimer</div> -->
            </div>
            <div>
                <!-- <section class="section section--full">
                    <h2 class="section__title">Vidéo</h2>
                    <div class="video" data-component="Video" data-video-id="<?php echo get_field('video_url')?>">
                        <div class="video__media js-video" style="color: white">
                            <img class="js-poster"
                                src="http://wordpress.localhost/pfe/wp-content/uploads/2022/02/thumbail.png"
                                alt="Vidéo pour <?php the_title()?>" />
                            <svg class="icon icon--xl icon--stroke">
                                <use xlink:href="#icon-play"></use>
                            </svg>
                        </div>
                    </div>
                </section> -->
                <a class="button" href="https://youtu.be/<?php echo get_field('video_url')?>" target="_blank">Lien
                    vers la
                    vidéo</a>
                <h3 class="inputEquivalent">Changer le lien du vidéo:</h3>
                <input type="text" id="video_id" name="video_id"
                    value="<?php echo get_post_meta(get_the_ID(), 'video_url', true); ?>" />
            </div>
        </section>
        <section class="center-width">
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
        </section>
    </form>
</div>
<?php get_footer(); ?>