<?php
/**
 * Halo1ArchiveController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1ArchiveController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        parent::getPageData();
        $page_data = get_queried_object();
        $type = get_query_var( 'post_type' );

        $archiveTitle = get_the_date();

        if ( is_day() ) :
            $this->page_model->setProperty('archive_name',get_the_date());
        elseif ( is_month() ) :
            $this->page_model->setProperty('archive_name',
              __( 'Monthly Archives:', 'Halo1' ). " " . get_the_date( _x( 'F Y', 'monthly archives date format', 'Halo1')));
        elseif ( is_year() ) :
            $this->page_model->setProperty('archive_name',
              __( 'Yearly Archives:', 'Halo1' ). " " . get_the_date( _x( 'Y', 'yearly archives date format', 'Halo1' )));
        elseif ( is_tag() ) :
            $this->page_model->setProperty('archive_name',$page_data->name);
            $this->page_model->setProperty('archive_description', $page_data->description);
        else:
            $this->page_model->setProperty('archive_name', __( 'Archives', 'Halo1' ));
        endif;

        $this->page_model->setProperty('empty_list_message', __('No posts in this archive.', 'Halo1'));

        global $wp_query;

        // recupero la pagina richiesta
        $page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $this->page_model->setProperty('paginator_data', $this->getPaginatorData(intval($page_number), intval($wp_query->max_num_pages)));
        $this->page_model->setProperty('post_type', $type);
        $this->page_model->setProperty('posts_list', $this->getPosts(0));
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
