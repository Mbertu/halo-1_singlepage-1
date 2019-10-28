<?php
/**
 * Halo1CategoryController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1CategoryController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        parent::getPageData();
        $page_data = get_queried_object();

        $this->page_model->setProperty('category_name', $page_data->name);
        $this->page_model->setProperty('category_content', $page_data->description);
        $this->page_model->setProperty('empty_category_message', __('No posts in this category.', 'Halo1'));

        global $wp_query;

        // recupero la pagina richiesta
        $page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $this->page_model->setProperty('paginator_data', $this->getPaginatorData(intval($page_number), intval($wp_query->max_num_pages)));
        $this->page_model->setProperty('posts_list', $this->getPosts(0));
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
