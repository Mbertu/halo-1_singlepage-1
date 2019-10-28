<?php
/**
 * Halo1PostsListController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1PostsListController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        $page_data = get_queried_object();

        if(!is_null($page_data)){
            $this->page_model->import($page_data->to_array());

            $this->page_model->setProperty('author', array('name'=> get_the_author_meta('display_name', $page_data->post_author),
                                                        'permalink' => get_author_posts_url($page_data->post_author)));

            $this->page_model->setProperty('post_content', $this->getPostContent($page_data, __('Continue reading...', 'Halo1')));

            if(has_post_thumbnail($page_data->ID)){
                $this->page_model->setProperty('post_image', wp_get_attachment_url( get_post_thumbnail_id($page_data->ID)));
            }
        }

        parent::getPageData();

        $this->page_model->setProperty('empty_category_message', __('No posts in this blog.', 'Halo1'));

        global $wp_query;

        // recupero la pagina richiesta
        $page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $this->page_model->setProperty('paginator_data', $this->getPaginatorData(intval($page_number), intval($wp_query->max_num_pages)));

        $this->page_model->setProperty('posts_list', $this->getPosts(0));
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
