<?php
/**
 * Halo1HomePageModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1HomePageModel extends Halo1AbstractFrontendModel {
  protected $post_content;
  protected $post_title;
  protected $post_subtitle;
  protected $post_image;

  protected $defaults = array(
  	'post_content' =>  '',
  	'post_title' => '',
    'post_subtitle' => '',
  	'post_image' => null
  );
}
