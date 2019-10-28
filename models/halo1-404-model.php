<?php
/**
 * Halo1404Model - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1404Model extends Halo1AbstractFrontendModel {
	protected $post_title;
	protected $post_content;
	protected $home_url;
	protected $home_link_label;

	protected $defaults = array(
		'post_title' => '',
		'post_content' => '',
		'home_url' => '',
		'home_link_label' => ''
	);
}