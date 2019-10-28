<?php
/**
 * Halo1HomePageController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1HomePageController extends Halo1AbstractFrontendController {

    public function init($args){
        parent::init($args);
        return;
    }

    protected function getPageData(){
        if(get_option( 'show_on_front' )=='posts'){
            echo '<p><strong>Attenzione!</strong> Per il corretto funzionamento del tema si prega di inserire una pagina <strong>statica</strong> come prima pagina.</p>';
            echo '<p><a href="/wp-admin/options-reading.php">MODIFICA LA PAGINA</a></p>';
            die;
        }
        parent::getPageData();
        $page_data = get_queried_object();
        $this->page_model->import($page_data->to_array());

        $subtitle_meta = get_metadata('post', $page_data->ID, 'halo1-subtitle-metabox-theme_config', true);
        if(!empty($subtitle_meta))
            $this->page_model->setProperty('post_subtitle', $subtitle_meta['subtitle']);

        if(!empty($page_data))
            $this->page_model->setProperty('post_content', $page_data->post_content);

        if(has_post_thumbnail($page_data->ID)){
            $this->page_model->setProperty('post_image', $this->getPostsThumbnails($page_data->ID));
        }

    }



    private function lang_page_id($id){
        if(function_exists('icl_object_id')) {
            return icl_object_id($id,'page',true);
        } else {
            return $id;
        }
    }
}
