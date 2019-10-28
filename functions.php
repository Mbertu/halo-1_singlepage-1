<?php
/**
 * Retorica Halo 1 functions and definitions.
 *
 * @package halo1
 */

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

function setup_halo1(){
    if ( ! isset( $content_width ) ) $content_width = 1200;
    $args = array(
        'controllers_path' => get_template_directory().'/controllers/',
        'views_path' => get_template_directory().'/views/',
        'models_path' => get_template_directory().'/models/'
    );

    // factory interfaces and classes
    require "includes/interface-halo1-factory.php";
    require "includes/halo1-factory.php";

    $factory = Halo1Factory::getInstance($args);
    $factory->createController('theme', 'theme');
}
add_action( 'after_setup_theme', 'setup_halo1' );


?>
