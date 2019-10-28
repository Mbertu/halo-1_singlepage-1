<?php
/**
 * Halo1SearchController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SearchController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        parent::getPageData();

        $this->page_model->setProperty('search_title', __('Results for:', 'Halo1').' '.get_search_query());
        $this->page_model->setProperty('empty_search_message', __('No results for this search.', 'Halo1'));

        global $wp_query;
        // recupero la pagina richiesta
        $page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $this->page_model->setProperty('paginator_data', $this->getPaginatorData(intval($page_number), intval($wp_query->max_num_pages)));
        $this->page_model->setProperty('posts_list', $this->getPosts(0));
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
