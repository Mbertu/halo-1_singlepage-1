<?php
/**
 * Halo1PostsListModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1PostsListModel extends Halo1AbstractFrontendModel {
	protected $posts_list;
	protected $post_content;
  protected $post_title;
  protected $post_excerpt;
  protected $author;
  protected $post_image;
  protected $empty_list_message;
  protected $paginator_data;

  protected $defaults = array(
  	'posts_list' => array(),
  	'post_content' =>  '',
  	'post_title' => '',
  	'post_excerpt' => '',
  	'author' => null,
  	'post_image' => null,
    'empty_list_message' => '',
    'paginator_data' => array()
  );
}
