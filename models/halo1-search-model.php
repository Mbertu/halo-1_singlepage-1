<?php
/**
 * Halo1SearchModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SearchModel extends Halo1AbstractFrontendModel {
	  protected $posts_list;
    protected $search_title;
    protected $empty_search_message;
    protected $post_type;
    protected $paginator_data;

    protected $defaults = array(
    	'posts_list' => array(),
    	'search_title' =>  '',
      'empty_search_message' => '',
      'post_type' => '',
      'paginator_data' => null
    );
}
