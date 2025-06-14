<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
    <!-- Header -->
    <header class="header" id="main-header">
        <div class="nav-container">
            <div class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Canarinho-logo.png" 
                     alt="<?php echo get_theme_mod('team_name', 'Canarinhos FC'); ?>" 
                     class="logo-image">
                <span class="logo-text"><?php echo get_theme_mod('team_name', 'CANARINHOS FC'); ?></span>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => 'canarinhos_fallback_menu',
                ));
                ?>
            </nav>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobile-toggle" aria-label="Toggle Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        
        <!-- Mobile Navigation -->
        <nav class="mobile-nav" id="mobile-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'mobile-nav-menu',
                'container' => false,
                'fallback_cb' => 'canarinhos_fallback_menu',
            ));
            ?>
        </nav>
    </header>