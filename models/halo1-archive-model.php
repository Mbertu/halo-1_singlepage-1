<?php
/**
 * Halo1ArchiveModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1ArchiveModel extends Halo1AbstractFrontendModel {
	protected $posts_list;
  protected $archive_name;
	protected $archive_description;
  protected $empty_list_message;
  protected $post_type;
  protected $paginator_data;

  protected $defaults = array(
  	'posts_list' => array(),
  	'archive_name' =>  '',
		'archive_description' => '',
    'empty_list_message' => '',
    'post_type' => '',
    'paginator_data' => null
  );
}
