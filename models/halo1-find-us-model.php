<?php
/**
 * Halo1FindUsModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1FindUsModel extends Halo1AbstractFrontendModel {
	protected $post_content;
    protected $post_title;
    protected $post_subtitle;
    protected $post_excerpt;
    protected $author;
    protected $page_image;

    protected $defaults = array(
    	'post_content' =>  '',
    	'post_title' => '',
        'post_subtitle' => '',
    	'post_excerpt' => '',
    	'author' => null,
    	'page_image' => null
    );
}
