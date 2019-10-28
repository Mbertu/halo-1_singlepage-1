<?php
/**
 * Halo1AbstractMetaboxModel - Abstract metabox model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractMetaboxModel extends Halo1AbstractModel{

	/**
	 * Method to init the model with input params or default values
	 * @since <%= plugin_version_number %>
	 */
	protected function init($args){
		$this->setProperty('version', isset($args['version']) ? $args['version'] : null );
		$this->setProperty('option_name', isset($args['option_name']) ? $args['option_name'] : null );
		$this->import($this->defaults);
	}

	public function initFromPostId($post_id){
		$this->import(get_post_meta( $post_id, $this->getOptionName(), true ));
	}

}