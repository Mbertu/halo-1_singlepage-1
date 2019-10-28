<?php
/**
 * Halo1FindUsController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1FindUsController extends Halo1AbstractFrontendController {

    protected function getPageData(){
        $page_data = get_queried_object();
        $this->page_model->import($page_data->to_array());

        parent::getPageData();

        if(!empty($page_data))
            $this->page_model->setProperty('post_content', $this->getPostContent($page_data, __('Continue reading...','Halo1')));

        if(has_post_thumbnail($page_data->ID)){
            $this->page_model->setProperty('post_image', wp_get_attachment_url( get_post_thumbnail_id($page_data->ID)));
        }
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

    protected function renderContent($only = false){
        $page_data = $this->page_model->toArray();
        $contacts_theme_config_model = $this->contacts_theme_config_model->toArray();

        $this->view->renderContent(array('page_data' => $page_data,
                                        'contacts_config' => $contacts_theme_config_model));
        return;
    }

    public function enqueueJs(){
        parent::enqueueJs();
    }
}
