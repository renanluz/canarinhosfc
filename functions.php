<?php
// Evita acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Configurações do tema
function canarinhos_theme_setup() {
    // Suporte a título dinâmico
    add_theme_support('title-tag');
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Suporte a menus
    add_theme_support('menus');
    
    // Registrar menus
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu'
    ));
    
    // Suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'canarinhos_theme_setup');

// Enfileirar scripts e estilos
function canarinhos_scripts() {
    // CSS principal
    wp_enqueue_style('canarinhos-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // JavaScript principal
    wp_enqueue_script('canarinhos-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localizar script para AJAX
    wp_localize_script('canarinhos-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('canarinhos_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'canarinhos_scripts');

// Customizer
function canarinhos_customize_register($wp_customize) {
    // Seção do time
    $wp_customize->add_section('canarinhos_team_section', array(
        'title' => 'Team Settings',
        'priority' => 30,
    ));
    
    // Campo para nome do time
    $wp_customize->add_setting('team_name', array(
        'default' => 'Canarinhos FC',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('team_name', array(
        'label' => 'Team Name',
        'section' => 'canarinhos_team_section',
        'type' => 'text',
    ));
    
    // Campo para slogan
    $wp_customize->add_setting('team_slogan', array(
        'default' => 'Detailed football games news & reviews',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('team_slogan', array(
        'label' => 'Team Slogan',
        'section' => 'canarinhos_team_section',
        'type' => 'textarea',
    ));
    
    // Seção de estatísticas
    $wp_customize->add_section('canarinhos_stats_section', array(
        'title' => 'Team Statistics',
        'priority' => 31,
    ));
    
    // Estatísticas
    $stats = array('fans', 'matches', 'years', 'trophies');
    $defaults = array('150+', '85', '25+', '12');
    
    foreach ($stats as $index => $stat) {
        $wp_customize->add_setting('stat_' . $stat, array(
            'default' => $defaults[$index],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('stat_' . $stat, array(
            'label' => ucfirst($stat),
            'section' => 'canarinhos_stats_section',
            'type' => 'text',
        ));
    }
    
    // Seção de redes sociais
    $wp_customize->add_section('canarinhos_social_section', array(
        'title' => 'Social Media',
        'priority' => 32,
    ));
    
    $socials = array('facebook', 'instagram', 'twitter', 'youtube');
    
    foreach ($socials as $social) {
        $wp_customize->add_setting($social . '_url', array(
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control($social . '_url', array(
            'label' => ucfirst($social) . ' URL',
            'section' => 'canarinhos_social_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'canarinhos_customize_register');

// Menu fallback
function canarinhos_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . home_url('/') . '" class="active">Home</a></li>';
    echo '<li><a href="#league">League</a></li>';
    echo '<li><a href="#events">Events</a></li>';
    echo '<li><a href="' . get_permalink(get_option('page_for_posts')) . '">Blog</a></li>';
    echo '<li><a href="#about">About Us</a></li>';
    echo '<li><a href="#contact">Contact</a></li>';
    echo '</ul>';
}

// Widget areas
function canarinhos_widgets_init() {
    register_sidebar(array(
        'name' => 'Main Sidebar',
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'canarinhos_widgets_init');

// Custom Post Type para Jogadores
function create_player_post_type() {
    register_post_type('player', array(
        'labels' => array(
            'name' => 'Players',
            'singular_name' => 'Player',
            'add_new' => 'Add New Player',
            'add_new_item' => 'Add New Player',
            'edit_item' => 'Edit Player',
            'new_item' => 'New Player',
            'view_item' => 'View Player',
            'search_items' => 'Search Players',
            'not_found' => 'No players found',
            'not_found_in_trash' => 'No players found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-groups',
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_player_post_type');

// Meta boxes para jogadores
function add_player_meta_boxes() {
    add_meta_box(
        'player-details',
        'Player Details',
        'player_details_callback',
        'player',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_player_meta_boxes');

function player_details_callback($post) {
    wp_nonce_field('save_player_details', 'player_details_nonce');
    
    $position = get_post_meta($post->ID, 'player_position', true);
    $number = get_post_meta($post->ID, 'player_number', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="player_position">Position:</label></th>';
    echo '<td><input type="text" id="player_position" name="player_position" value="' . esc_attr($position) . '" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="player_number">Number:</label></th>';
    echo '<td><input type="number" id="player_number" name="player_number" value="' . esc_attr($number) . '" /></td>';
    echo '</tr>';
    echo '</table>';
}

function save_player_details($post_id) {
    if (!isset($_POST['player_details_nonce']) || 
        !wp_verify_nonce($_POST['player_details_nonce'], 'save_player_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['player_position'])) {
        update_post_meta($post_id, 'player_position', sanitize_text_field($_POST['player_position']));
    }
    
    if (isset($_POST['player_number'])) {
        update_post_meta($post_id, 'player_number', intval($_POST['player_number']));
    }
}
add_action('save_post', 'save_player_details');

// Limpar wp_head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
?>