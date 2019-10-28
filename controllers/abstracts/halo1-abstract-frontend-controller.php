<?php
/**
 * Halo1AbstractFrontendController - abstract class for frontend controller
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */

abstract class Halo1AbstractFrontendController extends Halo1AbstractController{

    /**
     * Model object reference
     * @var Object
     */
    protected $page_model;

    /**
     * Socials theme config model
     * @var Object
     */
    protected $socials_theme_config_model;

    /**
     * Contacts theme config model
     * @var Object
     */
    protected $contacts_theme_config_model;


    /*
     * Init current object model
     * */
    public function init($args){
        $path = get_stylesheet_directory_uri();

        add_action("wp_enqueue_scripts", array($this, "enqueueCss"));
        add_action("wp_enqueue_scripts", array($this, "enqueueJs"));

        add_filter( 'get_search_form',  array($this, 'halo1SearchForm') );
        add_filter( 'the_content', array($this, 'theContentFilter'), 9);
        add_filter( 'embed_oembed_html',array( $this, 'embedContainer' ) );

        add_filter( 'widget_text', 'do_shortcode');

        add_filter( 'post_gallery', array($this, 'manageGallery'), 10, 4 );

        add_filter('comment_form_defaults', array($this,'custom_fields'));
        add_filter('comment_reply_link', array($this,'replace_reply_link_class'));

        $this->setProperty('page_model', $args['page_model']);
        $this->setProperty('socials_theme_config_model', $args['socials_model']);
        $this->setProperty('contacts_theme_config_model', $args['contacts_model']);
        $this->setProperty('view', $args['view']);

        $this->getPageData();
        return;
    }

    function custom_fields($fields) {
      $fields['submit_button'] = '<button type="submit" id="submit" name="submit">Commenta</button>';

      return $fields;
    }

    function replace_reply_link_class($class){
        $class = str_replace("class='comment-reply-link", "class='more-link", $class);
        return $class;
    }

    /**
     * Get the current page data
     */
    protected function getPageData(){
      $this->page_model->setProperty('site_name', get_bloginfo('name'));
      $this->page_model->setProperty('site_logo', get_custom_logo());
      $this->page_model->setProperty('site_description', get_bloginfo('description'));
      $this->page_model->setProperty('site_disclaimer',get_theme_mod('disclaimer'));
      $this->page_model->setProperty('site_separator',wp_get_attachment_url(get_theme_mod('separator')));
      $this->page_model->setProperty('site_charset', get_bloginfo('charset'));
      $this->page_model->setProperty('site_no_image',wp_get_attachment_image(get_theme_mod('no_image'),'posts-list'));
      $this->page_model->setProperty('html5shiv_js', get_template_directory_uri().'/assets/js/vendor/html5shiv-printshiv.min.js');
      $this->page_model->setProperty('menu_data', array(
          'main' => $this->getMenuData('main'),
          'pages' => $this->getMenuData('pages'),
          'privacy' => $this->getMenuData('privacy'),
      ));

      $this->page_model->setProperty('footer_socials',get_theme_mod('footer_socials'));
      $this->page_model->setProperty('footer_info',get_theme_mod('footer_info'));
      $this->page_model->setProperty('footer_disclaimer',get_theme_mod('footer_disclaimer'));
      $this->page_model->setProperty('footer_signature', get_theme_mod('footer_signature')=='retorica'?
        '<a href="http://www.retorica.net" rel="no-follow" target="_blank" title="Retorica Comunicazione"><img src="'.get_bloginfo('template_directory').'/assets/images/retorica-logo.png" /></a>' :
        get_theme_mod('footer_signature'));
    }

    public function enqueueCss(){
        wp_enqueue_style( 'style-css', get_stylesheet_directory_uri() . '/assets/css/halo1.css' );
        wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/bower_components/animate.css/animate.min.css' );
        wp_enqueue_style( 'pikaday-css', get_template_directory_uri() . '/bower_components/pikaday/css/pikaday.css' );
    }

    public function enqueueJs(){
        wp_enqueue_script( 'halo1-js', get_template_directory_uri() . '/assets/js/halo1.js', array('jquery'), '2.0.0', true );
        wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js', array(), '3.3.4', true );
        wp_enqueue_script( 'wow-js', get_template_directory_uri() . '/bower_components/wowjs/dist/wow.min.js', array('jquery'), '1.1.2', true );
        wp_enqueue_script( 'magnific-popup-js', get_template_directory_uri() . '/bower_components/magnific-popup/dist/jquery.magnific-popup.min.js', array(), '1.0.0', true );
        wp_enqueue_script( 'moment', get_template_directory_uri() . '/bower_components/moment/min/moment-with-locales.js',true);
        wp_enqueue_script( 'pikaday', get_template_directory_uri() . '/bower_components/pikaday/pikaday.js', array('moment'), true);
    }

    protected function getPostContent($current_post, $get_more = 0){
        global  $post,
                $more;
        $post = $current_post;
        setup_postdata( $post );
        $more = $get_more;
        $args = array();
        $args['before'] = '<div class="post-paginator">'.__('Post pages:','Halo1');
        $args['after'] = '</div>';
        $args['echo'] = 0;
        $args['link_before'] = '<span class="post-page">';
        $args['link_after'] = '</span>';
        $post_paginator = wp_link_pages($args);
        $content = get_the_content('');
        $content = str_replace( ']]>', ']]&gt;', $content );
        wp_reset_postdata( $post );
        return $content;
    }

    protected function getPosts(){
        global $wp_query;
        $posts_array = array();
        if(have_posts()){
            $posts = $wp_query->posts;
            foreach($posts as $post){
                $posts_array[$post->ID] = $post->to_array();
                $posts_array[$post->ID]['post_class'] = get_post_class(array('post_content'));
                $posts_array[$post->ID]['post_category'] = $this->getTaxonomyTermsForPost($post->ID, 'category');
                $posts_array[$post->ID]['tags_input'] = $this->getTaxonomyTermsForPost($post->ID, 'post_tag');
                $posts_array[$post->ID]['post_content'] = $this->getPostContent($post);
                $posts_array[$post->ID]['post_permalink'] = get_permalink($post->ID);
                $posts_array[$post->ID]['post_image'] = $this->getPostsThumbnails($post->ID);
                $posts_array[$post->ID]['post_author_name'] = get_the_author_meta('display_name', $post->post_author);
                $posts_array[$post->ID]['post_author_avatar'] = get_avatar(get_the_author_meta('ID', $post->post_author),22);
                $posts_array[$post->ID]['post_author_url'] = get_author_posts_url($post->post_author);
                $posts_array[$post->ID]['post_date'] = date_i18n(get_option( 'date_format' ),strtotime($post->post_date));
                $posts_array[$post->ID]['post_visits'] = do_shortcode('[post-views id="'.$post->ID.'"]');

                $subtitle_meta = get_metadata('post', $post->ID, 'halo1-subtitle-metabox-theme_config', true);
                if(!empty($subtitle_meta))
                    $posts_array[$post->ID]['post_subtitle'] = $subtitle_meta['subtitle'];
            }
        }
        return $posts_array;
    }

    protected function getPostsThumbnails($post_id){
        $array = [];
        $array['thumbnail'] = (has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'thumbnail') : null);
        $array['medium'] = (has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'medium') : null);
        $array['large'] = (has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'large') : null);
        $array['full'] = (has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'full') : null);
        $array['posts-list'] = (has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'posts-list') : null);
        return $array;
    }

    public function getTaxonomyTermsForPost($post_id, $taxonomy){
        return get_the_term_list($post_id, $taxonomy, '<li>', ',</li><li>', '</li>');
    }

    /**
     * Render the 3 view parts header, content, footer
     * @since 2.0.0
     */
    public function renderView($only = false){

        $this->renderHeader();

        $this->renderContent();

        $this->renderFooter();
        return;
    }

    /**
     * Render the header view
     * @since 2.4.0
     */
    protected function renderHeader($only = false){
        $page_data = $this->page_model->toArray();
        $socials_theme_config_model = $this->socials_theme_config_model->toArray();
        $contacts_theme_config_model = $this->contacts_theme_config_model->toArray();

        $this->view->renderHeader(array('page_data' => $page_data,
                                        'socials_config' => $socials_theme_config_model,
                                        'contacts_config' => $contacts_theme_config_model));
        return;
    }

    /**
     * Render the content view
     * @since 2.4.0
     */
    protected function renderContent($only = false){
        $page_data = $this->page_model->toArray();

        $this->view->renderContent(array('page_data' => $page_data));
        return;
    }

    /**
     * Render the footer view
     * @since 2.4.0
     */
    protected function renderFooter($only = false){
        $page_data = $this->page_model->toArray();
        $socials_theme_config_model = $this->socials_theme_config_model->toArray();
        $contacts_theme_config_model = $this->contacts_theme_config_model->toArray();

        $this->view->renderFooter(array('page_data' => $page_data,
                                        'socials_config' => $socials_theme_config_model,
                                        'contacts_config' => $contacts_theme_config_model));
        return;
    }

    /**
     * Wrap deglie embed tramite un div con classe "embed_container" necessario per poter uniformare il css degli embed
     * @param  [String] $html [codice generato dall'embed]
     * @return [String]       [nuovo codice html per l'embed]
     */
    public function embedContainer($html) {
        return '<div class="embed_container">' . $html . '</div>';
    }

    public function halo1SearchForm($form){
        ob_start();
        $this->view->renderSearchForm($form);
        $output =  ob_get_contents();
        ob_end_clean() ;
        return $output;
    }

    public function manageGallery($output = '', $attr, $content = false, $tag = false){
        $post = get_post();
        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( ! $attr['orderby'] ) {
                unset( $attr['orderby'] );
            }
        }

        $html5 = current_theme_supports( 'html5', 'gallery' );
        $atts = shortcode_atts( array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'itemtag'    => 'figure',
            'icontag'    => 'div',
            'captiontag' => 'figcaption',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => '',
            'link'       => ''
        ), $attr, 'gallery' );

        $id = intval( $atts['id'] );
        if ( 'RAND' == $atts['order'] ) {
            $atts['orderby'] = 'none';
        }

        if ( ! empty( $atts['include'] ) ) {
            $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( ! empty( $atts['exclude'] ) ) {
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
        } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
            }
            return $output;
        }

        $itemtag = tag_escape( $atts['itemtag'] );
        $captiontag = tag_escape( $atts['captiontag'] );
        $icontag = tag_escape( $atts['icontag'] );
        $valid_tags = wp_kses_allowed_html( 'post' );
        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
        }

        $columns = intval( $atts['columns'] );
        $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";
        $size_class = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='";
        $gallery_div .= (!empty( $atts['link'] ) && 'file' === $atts['link']) ? "halo1-gallery " : "";
        $gallery_div .= "galleryid-{$id} grid-row-flex' itemscope itemtype='http://schema.org/ImageGallery'>";

        /**
         * Filter the default gallery shortcode CSS styles.
         *
         * @since 2.5.0
         *
         * @param string $gallery_style Default gallery shortcode CSS styles.
         * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
         */
        $output = apply_filters( 'gallery_style', '' . $gallery_div );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {
            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_image( $id, $atts['size'], false );
            } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false );
            }

            $image_meta  = wp_get_attachment_metadata( $id );

            $orientation = '';
            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item col-xs-6 col-md-4 inside' itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'>";
            $output .= $image_output;
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption' itemprop='caption description'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        }
        $output .= "</div>";
        return $output;
    }

    /**
     * Hook the content, add popup-image class on image links
     */
    public function theContentFilter($content){
        $classes = 'popup-image';

        $patterns = array();
        $replacements = array();

        // class e href
        $patterns[0] = '/<a([^>]*)class=(\"|\')([^\"|\']*)(\"|\') href=(\"|\')([^\"|\']*)(\.jpg|\.png|\.gif)(\"|\')>(.*)<\/a>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes
        $replacements[0] = '<a\1 class=\2\3 ' . $classes . ' \4 href=\5\6\7\8>\9</a>';

        // href e class
        $patterns[1] = '/<a([^>]*)href=(\"|\')([^\"|\']*)(\.jpg|\.png|\.gif)(\"|\') class=(\"|\')([^\"|\']*)(\"|\')>(.*)<\/a>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes
        $replacements[1] = '<a\1 href=\2\3\4\5 class=\6\7 ' . $classes . ' \8>\9</a>';

        //href
        $patterns[2] = '/<a([^>]*)href=(\"|\')([^\"|\']*)(\.jpg|\.png|\.gif)(\"|\')>(.*)<\/a>/'; // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
        $replacements[2] = '<a\1 href=\2\3\4\5 class="' . $classes . '">\6</a>';

        $content = preg_replace($patterns, $replacements, $content);

        return $content;
    }


    /**
     * Let the controller to retrive the menu data
     * @since 2.2.0
     */
    protected function getMenuData($menu_id){
        if(!has_nav_menu( $menu_id )) return null;
        $menu_data = array();
        $menu_data['menu_toggle_label'] = __('Menu', 'Halo1');
        $menu_data['screen_reader_text'] = __('Skip to content', 'Halo1');
        $menu_data['menu_id'] = $menu_id;
        $menu_data['container_id'] = $menu_id.'-menu';
        $menu_data['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
        $menu_data['depth'] = 2;
        if($menu_id === 'sections'){
            $menu_data['walker'] = new Halo1WalkerSectionsMenu;
        }elseif($menu_id === 'footer'){
            $menu_data['walker'] = new Halo1WalkerFooterMenu;
        }elseif($menu_id === 'privacy'){
            $menu_data['walker'] = new Halo1WalkerPrivacyMenu;
        }else{
            $menu_data['walker'] = new Halo1WalkerMainMenu;
        }
        return $menu_data;
    }

    /**
     * Let the controller to retrive all paginator data
     * @since 2.0.0
     */
    protected function getPaginatorData($page, $max_num_pages) {
        $paginator_data = array('links' => array());

        // if only one page stop the executiona
        if( $max_num_pages <= 1 )
            return $paginator_data;

        $paginator_data['links'][$page] = 'active';

        if(($page - 1) > 0){
            $paginator_data['links'][$page - 1] = esc_url( get_pagenum_link($page-1));
        }

        if(($page - 2) > 0){
            $paginator_data['links'][$page - 2] = esc_url( get_pagenum_link($page-2));
        }

        if(($page - 3) > 0){
            $paginator_data['links'][$page - 3] = esc_url( get_pagenum_link($page-3));
        }

        if(($page + 1) <= $max_num_pages){
            $paginator_data['links'][] = esc_url( get_pagenum_link($page+1));
        }

        if(($page + 2) <= $max_num_pages){
            $paginator_data['links'][] = esc_url( get_pagenum_link($page+2));
        }

        if(($page + 3) <= $max_num_pages){
            $paginator_data['links'][] = esc_url( get_pagenum_link($page+3));
        }

        // order array by key.
        ksort($paginator_data['links']);

        // previous page link
        if($page > 1){
            $paginator_data['prev_link'] = get_previous_posts_link(__('Prev.', 'Halo1'));
        }

        // first page link
        if($page > 4){
            $paginator_data['first_link'] = esc_url( get_pagenum_link(1));
        }

        // link to next page
        if($page < $max_num_pages ){
            $paginator_data['next_link'] = get_next_posts_link(__('Next', 'Halo1'));
        }

        // last page link
        if($max_num_pages - $page > 4){
            $paginator_data['last_link'] = esc_url( get_pagenum_link($max_num_pages));
        }

        return $paginator_data;
    }

    protected function getCommentsData($comments, $post_id){
        /**
         * Se il post è protetto da password non carico la form e i commenti
         */
        if ( post_password_required($post_id) ) {
            return;
        }

        ob_start();
        ?>
        <div id="comments" class="comments-area">

            <?php if ( $comments['count'] ) : ?>

            <h2 class="comments-title">
                <?php
                    printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments['count'], 'twentyfourteen' ),
                        number_format_i18n( $comments['count'] ), get_the_title($post_id) );
                ?>
            </h2>

            <?php if ( isset($comments['max_num_pages']) && $comments['max_num_pages'] > 1 ) : ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation','Halo1' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments','Halo1' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;','Halo1' ) ); ?></div>
            </nav><!-- #comment-nav-above -->
            <?php endif; // Check for comment navigation. ?>

            <ol class="comment-list">
                <?php
                    wp_list_comments( array(
                        'style'      => 'ol',
                        'short_ping' => true,
                        'avatar_size'=> 34,
                    ), $comments['commentsList'] );
                ?>
            </ol><!-- .comment-list -->

            <?php if ( isset($comments['max_num_pages']) && $comments['max_num_pages'] > 1 ) : ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation','Halo1' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments','Halo1' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;','Halo1' ) ); ?></div>
            </nav><!-- #comment-nav-below -->
            <?php endif; // Check for comment navigation. ?>

            <?php if ( ! comments_open($post_id) ) : ?>
            <p class="no-comments"><?php _e( 'Comments are closed.','Halo1' ); ?></p>
            <?php endif; ?>

            <?php endif; // have_comments() ?>

            <?php comment_form(); ?>

        </div><!-- #comments -->
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
