<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php the_title() ?> – PFE</title>
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/dist/styles/main.css">
    <link rel="icon" href="<?php bloginfo('template_url') ?>/dist/assets/images/logo.png">
    <script src="<?php bloginfo('template_url') ?>/dist/scripts/main.js" defer></script>
</head>

<body>
    <header data-component="Header" data-auto-hide="true" data-scroll-limit="0.1" class="header">
        <div class="header__icon-mobile">
            <a href="<?php blogInfo('url');?>"></a>
        </div>
        <div class="wrapper">
            <nav class="nav-primary">

                <?php wp_nav_menu(array(
                    'theme_location' => 'menu_main',
                    'container' => 'ul',
                    )); ?>
                <?php ?>

            </nav>
            <button class="header__toggle js-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>