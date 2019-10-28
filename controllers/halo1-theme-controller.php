<?php
/**
* Classe che grestisce le opzioni del tema, si occupa di recuperare le opzioni relative ad un controller
* genera la pagina di configurazione e si occupa di salvare / caricare le opzioni.
*
* @package Halo 1
*/

class Halo1ThemeController {

    /**
    * Theme version, used for cache-busting of style and script file references.
    * @since 1.0.0
    */
    private $version = "2.7.0";

    private $theme_slug = 'Halo1';

    private static $instance;

    private $settings = array();

    private $theme_config_controllers;

    private $frontend_controllers;

    private $metabox_controllers;

    private $site_config = array();

    /**
    * Reference to the Factory Object
    * @var Object
    */
    private $factory;

    /*
    * Costruttore dichiarato protected per impedire la diretta invocazione
    * */
    public function __construct() {}

        /*
        * Metodo per instanziare l'oggetto di tipo OptionsManager
        * implementazione del pattern singleton
        * */
        public static function getInstance($className, $args) {
            if ( !isset( self::$instance ) ) {
                self::$instance = new Halo1ThemeController();
                self::$instance->init($args);
            }
            return self::$instance;
        }

        /*
        * Init dell'oggetto options manager.
        * Vengono recuperate tutte le opzioni salvate sul db.
        */
        private function init($args){
            $this->setFactory($args['factory-instance']);

            $this->theme_config_controllers = array(
                'socials'     => null,
                'contacts'    => null,
            );

            $this->frontend_controllers = array(
                'home-page'     => null,
                'find-us'       => null,
                'posts-list'    => null,
                'page'          => null,
                'single'        => null,
                'search'        => null,
                'author'        => null,
                'category'      => null,
                'archive'       => null,
                '404'           => null,
                'header'        => null,
                'footer'        => null
            );

            $this->frontend_views = array(
                'halo16-widget' => null,
            );

            $this->metabox_controllers = array(
                'subtitle-metabox'    => null
            );

            $this->site_config['site_name'] = get_bloginfo('name');
            $this->site_config['site_description'] = get_bloginfo('description');

            $this->settings['socials'] = get_option($this->generateOptionName('socials'));
            $this->settings['contacts'] = get_option($this->generateOptionName('contacts'));

            load_theme_textdomain( 'Halo1', get_template_directory() . '/languages' );

            // This theme supports a variety of post formats.
            add_theme_support( 'post-formats', array( 'video', 'gallery', 'link', 'image') );
            add_theme_support( 'html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption') );
            add_theme_support( 'menus' );
            add_theme_support( 'widgets' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'automatic-feed-links' );

            // Setup the WordPress core custom background feature.
            add_theme_support( 'custom-background', array(
                'default-color' => 'ffffff',
                'default-image' => '',
            ) );

            add_theme_support( 'custom-logo', array(
                'height'      => 200,
                'width'       => 800,
                'flex-height' => true,
                'flex-width'  => true,
            ));
            //add_theme_support( 'site-logo', size )

            add_action('init', array($this, 'registerMenuArea'));
            add_action('widgets_init', array( $this, 'registerWidgetAreas'));

            add_action('customize_register', array($this, 'addThemeCustomize'));
            add_action('customize_register', array($this, 'addHeader'));
            add_action('customize_register', array($this, 'addContent'));
            add_action('customize_register', array($this, 'addFooter'));

            add_filter('image_resize_dimensions', array($this, 'halo1ImageResizeDimensions'), 10, 6);

            add_image_size('halo16-img', 730, 550, true);

            if(is_admin()){
                add_action('admin_menu', array($this, 'initHalo1SettingsMenuPage'));
                add_action('admin_init', array($this, 'initHalo1SettingsSections'));

                if($this->edit_form_after_title_supported()){
                    add_action('edit_form_after_title', array( $this, 'addFieldAfterTitle'));
                }else{
                    add_action('add_meta_boxes', array( $this, 'addMetabox'));
                }

                add_action('save_post', array( $this, 'savePost'));
                add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStyles'));
                add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
                $this->initAdminControllers();
                $this->initMetaboxes();
            } else {
                add_filter('pre_get_posts', array($this, 'blogPostsCountFilter'), 10, 6);
                add_action('renderFrontendHalo16WidgetRegistered', array($this, 'registerRenderFrontendHalo16Widget'));
            }
        }

        public function registerRenderFrontendHalo16Widget($args){
            remove_all_actions($args);
            add_action('renderFrontendHalo16Widget',array($this,'renderFrontendHalo16Widget'));
        }

        public function renderFrontendHalo16Widget($args){
          $view = $this->initFrontendViews('halo16-widget');
          $view->renderContent($args);
        }

        /**
        * Register the Theme tab in theme customization section.
        *
        * @since 2.10.0
        */
        public function addThemeCustomize($wp_customize){
            $wp_customize->add_panel('theme', array(
                'title' => 'Theme',
                'priority' => 1,
            ));
        }

        /**
        * Register the Header tab in theme customization section.
        *
        * @since 2.10.0
        */
        public function addHeader($wp_customize)
        {
            $wp_customize->add_section( 'header', array(
                'title' => 'Header',
                'priority' => 1,
                'panel' => 'theme'
            ));
        }

        /**
        * Register the Content tab in theme customization section.
        *
        * @since 2.10.0
        */
        public function addContent($wp_customize)
        {
            $wp_customize->add_section( 'content', array(
                'title' => 'Content',
                'priority' => 1,
                'panel' => 'theme'
            ));

            $wp_customize->add_setting('no_image', array(
                'default'        => '',
            ) );
            $wp_customize->add_control( new  WP_Customize_Cropped_Image_Control($wp_customize, 'no_image', array(
                'label'    => 'No Image',
                'section'  => 'content',
                'width'       => 725,
                'height'      => 485,
            )));

            $wp_customize->add_setting('halo16_center', array(
                'default'        => false,
            ) );
            $wp_customize->add_control( 'halo16_center', array(
                'label'    => 'Allineamento centrale halo16',
                'section'  => 'content',
                'type'      => 'checkbox',
            ));

        }



        /**
        * Register the Footer tab in theme customization section.
        *
        * @since 2.10.0
        */
        public function addFooter($wp_customize)
        {
            $wp_customize->add_section( 'footer', array(
                'title' => 'Footer',
                'priority' => 1,
                'panel' => 'theme'
            ));

            $wp_customize->add_setting('footer_socials', array(
                'default' => null,
            ));

            $wp_customize->add_control('footer_socials', array(
                'label' => __('Footer Socials Section', 'Halo1'),
                'description' => 'USE HALO2 SHORTCODE: [halo2-social]',
                'section' => 'footer',
                'type' => 'textarea',
            ));

            $wp_customize->add_setting('footer_info', array(
                'default' => null,
            ));

            $wp_customize->add_control('footer_info', array(
                'label' => __('Footer Info Section', 'Halo1'),
                'description' => 'TAG SUPPORTED: [h1] [p] [a] [i]. CLASS: [inside]',
                'section' => 'footer',
                'type' => 'textarea',
            ));

            $wp_customize->add_setting( 'footer_disclaimer', array(
                'default'        => '',
            ) );
            $wp_customize->add_control( 'footer_disclaimer', array(
                'label'   => 'Footer Disclaimer Section',
                'description' => 'TAG SUPPORTED: [p]',
                'section' => 'footer',
                'type'    => 'text',
            ));

            $wp_customize->add_setting('footer_signature', array(
                'default' => null,
            ));

            $wp_customize->add_control('footer_signature', array(
                'label' => __('Footer Signature Section', 'Halo1'),
                'description' => 'TAG SUPPORTED: [p] [a]. Input \'retorica\' for display the retorica logo.',
                'section' => 'footer',
                'type' => 'textarea',
            ));

        }


        private function initAdminControllers(){
            foreach($this->theme_config_controllers as $key => $object){
                // Check the existence of the controller instance
                if(!is_null($this->theme_config_controllers[$key])){
                    continue;
                }
                $model_args = array(
                    'version' => $this->version,
                    'option_name' => $this->generateOptionName($key),
                    'page_name' => $key,
                );
                $model = $this->factory->createModel('theme-config', $key, $model_args);
                $model->import($this->settings[$key]);
                $view = $this->factory->createView('theme-config', $key);
                $this->theme_config_controllers[$key] = $this->factory->createController('theme-config', $key, array('version' => $this->version, 'theme_slug' => 'Halo1', 'site_config' => $this->site_config, 'model' => $model, 'view' => $view));
            }
        }

        public function initFrontend($page){
            // Check the existence of the controller instance
            if(isset($this->frontend_controllers[$page]) && !is_null($this->frontend_controllers[$page])){
                $this->frontend_controllers[$page]->renderView();
                return;
            }

            $args = array('version' => $this->version, 'theme_slug' => 'Halo1');

            // Socials config model init
            $model_args = array(
                'version' => $this->version,
                'option_name' => $this->generateOptionName('socials'),
                'page_name' => 'socials'
            );
            $socials_config = $this->factory->createModel('theme-config', 'socials', $model_args);
            if(is_wp_error($socials_config)){
                echo $socials_config->get_error_message();
                return;
            }
            $socials_config->import($this->settings['socials']);
            $args['socials_model'] = $socials_config;

            // Contacts model
            $model_args = array(
                'version' => $this->version,
                'option_name' => $this->generateOptionName('contacts'),
                'page_name' => 'contacts'
            );
            $contacts_config = $this->factory->createModel('theme-config', 'contacts', $model_args);
            if(is_wp_error($contacts_config)){
                echo $contacts_config->get_error_message();
                return;
            }

            $contacts_config->import($this->settings['contacts']);
            $contacts_config->setProperty('theme_folder', get_stylesheet_directory_uri());

            $args['contacts_model'] = $contacts_config;

            // page model
            $model_args = array(
                'version' => $this->version,
                'page_name' => $page
            );
            $page_model = $this->factory->createModel('frontend', $page, $model_args);
            if(is_wp_error($page_model)){
                echo $page_model->get_error_message();
                return;
            }
            $args['page_model'] = $page_model;

            $view = $this->factory->createView('frontend', $page);
            if(is_wp_error($view)){
                echo $view->get_error_message();
                return;
            }
            $args['view'] = $view;

            $this->frontend_controllers[$page] = $this->factory->createController('frontend', $page, $args);

            if(is_wp_error($this->frontend_controllers[$page])){
                echo $frontend_controllers[$page]->get_error_message();
                return;
            }
            $this->frontend_controllers[$page]->renderView();
        }

        public function initFrontendViews($name){
            // Check the existence of the view instance
            if(isset($this->frontend_views[$name]) && !is_null($this->frontend_views[$name])){
                return $this->frontend_views[$name];
            }

            $view = $this->factory->createView('frontend', $name);
            if(is_wp_error($view)){
                echo $view->get_error_message();
                return;
            }
            $this->frontend_views[$name] = $view;
            return $view;
        }

        public function initMetaboxes(){
            foreach($this->metabox_controllers as $key => $object){
                // Check the existence of the controller instance
                if(!is_null($this->metabox_controllers[$key])){
                    continue;
                }
                $model_args = array(
                    'version' => $this->version,
                    'option_name' => $this->generateOptionName($key)
                );
                $model = $this->factory->createModel('metabox', $key, $model_args);
                $view = $this->factory->createView('metabox', $key);
                $metabox_controller = $this->factory->createController('metabox', $key, array('version' => $this->version, 'model' => $model, 'view' => $view, 'nonce' => 'halo1_'.$key));
                if(is_wp_error($metabox_controller)){
                    echo $metabox_controller->get_error_message();
                    return;
                }
                $this->metabox_controllers[$key] = $metabox_controller;
            }
        }

        /**
        * Init the theme setting pages
        * @since 1.0.0
        */
        public function initHalo1SettingsMenuPage(){
            foreach($this->theme_config_controllers as $controller){
                $controller->addMenuPage();
            }
        }

        /**
        * Init the theme setting sections
        * @since  1.0.0
        */
        public function initHalo1SettingsSections(){
            foreach($this->theme_config_controllers as $controller){
                $controller->setupSettingSections();
            }
        }

        /**
        * Init the theme setting pages
        * @since  2.3.0
        */
        public function addMetabox($post){
            if(!$screen = get_current_screen())
            return;
            if($screen->id == 'page' && $screen->post_type == 'page'
            || $screen->id == 'post' && $screen->post_type == 'post'){
                foreach($this->metabox_controllers as $controller){
                    $controller->setProperty('current_page', $screen->id);
                    $controller->setFieldAfterTitle(false);
                    $controller->renderView();
                }
            }
        }

        public function addFieldAfterTitle($post){
            if(!$screen = get_current_screen())
            return;
            if($screen->id == 'page' && $screen->post_type == 'page'
            || $screen->id == 'post' && $screen->post_type == 'post'){
                foreach($this->metabox_controllers as $controller){
                    $controller->setProperty('current_page', $screen->id);
                    $controller->setFieldAfterTitle(true);
                    $controller->getMetaboxData($post->ID);
                    $controller->renderView();
                }
            }
        }

        /**
        * Save metaboxes
        * @return 2.3.0
        */
        public function savePost($post_id){
            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            if(!$screen = get_current_screen())
            return;

            if($screen->id == 'page' && $screen->post_type == 'page'
            || $screen->id == 'post' && $screen->post_type == 'post'){
                $args = array('post_id' => $post_id, '_post' => $_POST);
                foreach($this->metabox_controllers as $controller)
                $controller->saveMetadata($args);
            }
        }

        public function enqueueAdminStyles(){
            if(isset($_GET['page'])){
                if(sanitize_text_field( $_GET['page']) == 'halo1_socials_config'){
                    $this->theme_config_controllers['socials']->enqueueCss();
                }
                if(sanitize_text_field( $_GET['page']) == 'halo1_contacts_config'){
                    $this->theme_config_controllers['contacts']->enqueueCss();
                }
            }
            if(!$screen = get_current_screen())
            return;
            if($screen->id == 'page' && $screen->post_type == 'page'
            || $screen->id == 'post' && $screen->post_type == 'post'){
                foreach($this->metabox_controllers as $controller){
                    $controller->enqueueCss();
                }
            }
        }

        public function enqueueAdminScripts(){
            if(isset($_GET['page'])){
                if(sanitize_text_field( $_GET['page']) == 'halo1_socials_config'){
                    $this->theme_config_controllers['socials']->enqueueJs();
                }
                if(sanitize_text_field( $_GET['page']) == 'halo1_contacts_config'){
                    $this->theme_config_controllers['contacts']->enqueueJs();
                }
            }
            if(!$screen = get_current_screen())
            return;
            if($screen->id == 'page' && $screen->post_type == 'page'
            || $screen->id == 'post' && $screen->post_type == 'post'){
                foreach($this->metabox_controllers as $controller){
                    $controller->enqueueJs();
                }
            }
        }

        /**
        * Registrazione delle aree widget
        */
        public function registerWidgetAreas() {

            register_sidebar( array(
                'name' => 'Home widget area',
                'id' => 'home_widget_area',
                'before_widget' => '<section class="home_widget">',
                'after_widget' => '</section>',
                'before_title' => '',
                'after_title' => '',
            ) );
        }

        /**
        * Registrazione dei menu
        *
        */
        public function registerMenuArea() {
            register_nav_menu( 'main', __( 'Main Menu', 'Halo1' ) );
            register_nav_menu( 'pages', __( 'Pages Menu','Halo1' ) );
            register_nav_menu( 'privacy', __( 'Privacy Menu','Halo1' ) );
        }

        public function halo1ImageResizeDimensions( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ){
            // Change this to a conditional that decides whether you
            // want to override the defaults for this image or not.
            if( !$crop || false)
            return $payload;

            // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
            $orig_ratio = $orig_w / $orig_h;
            $dest_ratio = $dest_w / $dest_h;

            $s_x = 0;
            $s_y = 0;
            $src_w = $orig_w;
            $src_h = $orig_h;

            if($orig_ratio > $dest_ratio){
                $src_w = $orig_h * $dest_ratio;
                $s_x = ($orig_w - $src_w) / 2;
            }
            if($orig_ratio < $dest_ratio){
                $src_h = $orig_w / $dest_ratio;
                $s_y = ($orig_h - $src_h) / 2;
            }

            // the return array matches the parameters to imagecopyresampled()
            // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
            return array( 0, 0, (int) $s_x, (int) $s_y, (int) $dest_w, (int) $dest_h, (int) $src_w, (int) $src_h );
        }

        /**
        * Fix sticky posts posts, counter
        * @since  2.6.7
        */
        public function blogPostsCountFilter($query) {
            $query->set('ignore_sticky_posts', '1');
            if ($query->is_search) {
                $query->set('post_type', 'post');
            }

            return $query;
        }

        /**
        * GET factory
        */
        public function getFactory(){
            return $this->factory;
        }

        /**
        * SET factory
        */
        public function setFactory($factory){
            $this->factory = $factory;
        }

        /**
        * Check if current version of wordpress support edit_form_after_title
        *
        * @since  2.3.0
        *
        * @param   string  $post_type  Post type.
        * @return  bool
        */
        private function edit_form_after_title_supported() {
            global $wp_version;
            if(version_compare($wp_version, '3.5', '<')){
                return false;
            }
            return true;
        }

        /**
        * Generate the option name from pagename
        * @since  2.5.0
        */
        private function generateOptionName($page){
            return 'halo1-'.$page.'-theme_config';
        }
    }
