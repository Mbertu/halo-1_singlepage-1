<?php
/**
 * Halo1PageController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1PageController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        $page_data = get_queried_object();

        $this->page_model->import($page_data->to_array());

        parent::getPageData();

        $this->page_model->setProperty('post_id', $page_data->ID);
        $subtitle_meta = get_metadata('post', $page_data->ID, 'halo1-subtitle-metabox-theme_config', true);
        if(!empty($subtitle_meta))
            $this->page_model->setProperty('post_subtitle', sanitize_text_field($subtitle_meta['subtitle']));

        $this->page_model->setProperty('post_class', get_post_class(array('post_content','clearfix'), $page_data->ID));

        if(!empty($page_data))
            $this->page_model->setProperty('post_content', $this->getPostContent($page_data, __('Continue reading...','Halo1')));

        if(has_post_thumbnail($page_data->ID)){
            $this->page_model->setProperty('post_image', $this->getPostsThumbnails($page_data->ID));
        }

        // setto variabili relative ai commenti
        $comments = array(
            'opened'    => comments_open($page_data->ID),
            'count'     => $page_data->comment_count,
        );

        if(get_option( 'page_comments' )){
            $comments['max_num_pages'] = ceil($page_data->comment_count / get_option('comments_per_page'));
        }

        if($page_data->comment_count != 0){
            $commentsList = get_comments(array(
                'post_id'   => $page_data->ID,
                'status'    => 'approve'
            ));
            $comments['commentsList'] = $commentsList;
            $comments['walker'] = new Halo1WalkerComments();
        }

        $this->page_model->setProperty('comments_data', $comments);

        $parents = get_post_ancestors( $page_data->ID );
        $parent = ($parents) ? $parents[count($parents)-1]: $page_data->ID;
        $parent_title = $page_data->ID == $parent ? $page_data->post_title : get_the_title($parent);
        $parent_li = "<a href=\"".get_permalink($parent)."\" >".$parent_title."</a>";
        $tree = wp_list_pages(array('child_of' => $parent, 'echo' => 0, 'title_li' => $parent_li ));
        $this->page_model->setProperty('page_tree', $tree);
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
