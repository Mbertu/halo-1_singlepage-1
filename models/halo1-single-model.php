<?php
/**
 * Halo1SingleModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SingleModel extends Halo1AbstractFrontendModel {
	protected $post_id;
	protected $post_content;
  protected $post_title;
  protected $post_subtitle;
  protected $post_class;
  protected $post_excerpt;
  protected $post_image;
  protected $post_format;
  protected $post_date;
  protected $post_category;
  protected $tags_input;
  protected $author;
  protected $comments_data;
  protected $post_navigation;

  protected $defaults = array(
  	'post_id' => null,
  	'post_content' =>  '',
  	'post_title' => '',
    'post_subtitle' => '',
    'post_class' => null,
  	'post_excerpt' => '',
  	'post_image' => null,
  	'post_format' => 'standard',
  	'post_date' => null,
  	'post_category' => array(),
  	'tags_input' => array(),
  	'author' => null,
    'comments_data' => null,
    'post_navigation' => null
  );
}
