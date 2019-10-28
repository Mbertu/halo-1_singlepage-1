<?php
/**
 * Halo1SingleController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SingleController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        $page_data = get_queried_object();

        $this->page_model->import($page_data->to_array());

        parent::getPageData();

        $this->page_model->setProperty('author', array('name'=> get_the_author_meta('display_name', $page_data->post_author),
                                                    'permalink' => get_author_posts_url($page_data->post_author)));

        $this->page_model->setProperty('post_id', $page_data->ID);

        $this->page_model->setProperty('post_category', $this->getTaxonomyTermsForPost($this->page_model->getProperty('post_id'), 'category'));
        $this->page_model->setProperty('tags_input', $this->getTaxonomyTermsForPost($this->page_model->getProperty('post_id'), 'post_tag'));

        $subtitle_meta = get_metadata('post', $page_data->ID, 'halo1-subtitle-metabox-theme_config', true);
        if(!empty($subtitle_meta))
            $this->page_model->setProperty('post_subtitle', sanitize_text_field($subtitle_meta['subtitle']));

        $this->page_model->setProperty('post_class', get_post_class(array('post_content', 'clearfix'), $page_data->ID));

        if(!empty($page_data))
            $this->page_model->setProperty('post_content', $this->getPostContent($page_data, __('Continue reading...','Halo1')));

        if(has_post_thumbnail($page_data->ID)){
            $this->page_model->setProperty('post_image', $this->getPostsThumbnails($page_data->ID));
        }

        global $post;
        $post = $page_data;
        $navigation_array = array(
            'next' => $this->getNavigationlink(get_adjacent_post(false,'',true)),
            'prev' => $this->getNavigationlink(get_adjacent_post(false,'',false))
        );
        wp_reset_postdata( $post );

        $this->page_model->setProperty('post_navigation', $navigation_array);


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

        if($format = get_post_format($page_data->ID))
            $this->page_model->setProperty('post_format', $format);
        if($post_type = get_post_type($page_data->ID))
            $this->page_model->setProperty('post_type', $post_type);
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

    private function getNavigationlink($post){
        if(is_null($post) || empty($post))
            return null;
        return array('permalink' => get_permalink($post->ID), 'label' => $post->post_title);
    }
}
