<?php
/**
 * Halo1PageModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1PageModel extends Halo1AbstractFrontendModel {
	protected $post_id;
	protected $post_content;
  protected $post_title;
  protected $post_subtitle;
  protected $post_class;
  protected $post_excerpt;
  protected $post_image;
  protected $comments_data;
  protected $page_tree;

  protected $defaults = array(
  	'post_id' => null,
  	'post_content' =>  '',
  	'post_title' => '',
    'post_subtitle' => '',
    'post_class' => null,
  	'post_excerpt' => '',
  	'post_image' => null,
  	'page_tree' => null,
    'comments_data' => null
  );
}
