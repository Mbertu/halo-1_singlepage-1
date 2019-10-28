<?php
/**
 * Halo1CategoryModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1CategoryModel extends Halo1AbstractFrontendModel {
	protected $posts_list;
	protected $category_content;
  protected $category_name;
  protected $empty_category_message;
  protected $paginator_data;

  protected $defaults = array(
  	'posts_list' => array(),
  	'category_content' =>  '',
  	'category_name' => '',
    'empty_category_message' => '',
    'paginator_data' => null
  );
}
