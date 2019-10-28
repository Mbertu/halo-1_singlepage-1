<?php
/**
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1AuthorController extends Halo1AbstractFrontendController {

  protected function getPageData(){
    parent::getPageData();
    $author = get_queried_object();

		$this->page_model->setProperty('user_email', $author->data->user_email);
		$this->page_model->setProperty('user_website', $author->data->user_url);
		$this->page_model->setProperty('user_name', $author->data->display_name);
    $this->page_model->setProperty('user_avatar', get_avatar( $author->data->ID ,180));
    $this->page_model->setProperty('user_description', get_the_author_meta('description',$author->data->ID));
		$this->page_model->setProperty('socials',
      array(
        'google-plus' =>  get_the_author_meta('googleplus', $author->data->ID),
        'facebook'   =>  get_the_author_meta('facebook', $author->data->ID),
        'twitter'    =>  get_the_author_meta('twitter', $author->data->ID)
			)
		);
    $this->page_model->setProperty('empty_list_message', __('No posts for this author.', 'Halo1'));

    global $wp_query;
    // recupero la pagina richiesta
    $page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $this->page_model->setProperty('paginator_data', $this->getPaginatorData(intval($page_number), intval($wp_query->max_num_pages)));
    $this->page_model->setProperty('posts_list', $this->getPosts(0));
    $this->page_model->setProperty('show_breadcrumbs',true);
  }
}
