<?php
/**
 * Halo1AbstractMetaboxController - Abstract metabox controller for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractMetaboxController extends Halo1AbstractController{

    /**
     * Nonce phrase needed to validate the form input
     * @since <%= plugin_version_number %>
     */
    protected $nonce_phrase;

    protected $current_page;

    /**
     * Init the controller
     * @since <%= plugin_version_number %>
     */
    public function init($args){
        $this->setProperty('model', isset($args['model']) ? $args['model'] : null);
        $this->setProperty('view', isset($args['view']) ? $args['view'] : null);
        $this->setProperty('nonce_phrase', isset($args['nonce']) ? $args['nonce'] : null);
        $this->setProperty('current_page', isset($args['current_page']) ? $args['current_page'] : null);
    	return;
    }

    /**
     * Enqueue the css for all metaboxes
     * @since <%= plugin_version_number %>
     */
    public function enqueueCss(){
        wp_enqueue_style("halo1-metabox-css", get_template_directory_uri()."/assets/css/halo1-metabox.css");
        return;
    }

    /**
     * Enqueue the js for all metaboxes
     * @since <%= plugin_version_number %>
     */
    public function enqueueJs(){
    	wp_enqueue_script("halo1-metabox-javascript", get_template_directory_uri()."/assets/js/halo1-metabox.js", array("jquery"), $this->getProperty('model')->getProperty('version'));
        return;
    }

    /**
     * Abstract, save metadata for the current resource
     * @since <%= plugin_version_number %>
     */
	public abstract function saveMetadata($args);

    /**
     * Abstract, get metadata for the current resource
     * @since <%= plugin_version_number %>
     */
    protected abstract function getMetaboxData($post_id);
}