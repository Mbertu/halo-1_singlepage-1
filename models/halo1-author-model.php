<?php
/**
 * Halo1AuthorModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1AuthorModel extends Halo1AbstractFrontendModel {
	protected $user_email;
	protected $user_website;
	protected $user_name;
	protected $user_avatar;
	protected $user_description;
	protected $socials;
	protected $posts_list;
	protected $empty_list_message;
	protected $paginator_data;

	protected $defaults = array(
		'user_email' => '',
		'user_website' => '',
		'user_name' => '',
		'user_avatar' => '',
		'socials' => array(),
		'user_description' => '',
		'posts_list' => '',
		'empty_list_message' => '',
		'paginator_data' => null
	);
}
