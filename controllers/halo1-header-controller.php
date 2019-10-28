<?php
/**
 * Halo1HeaderController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1HeaderController extends Halo1AbstractFrontendController {

    public function renderView($only = false){
        $page_data = $this->page_model->toArray();
        $socials_theme_config_model = $this->socials_theme_config_model->toArray();
        $contacts_theme_config_model = $this->contacts_theme_config_model->toArray();

        $this->view->renderHeader(array('page_data' => $page_data,
                                        'socials_config' => $socials_theme_config_model,
                                        'contacts_config' => $contacts_theme_config_model));
        return;
    }

    protected function getPageData(){
        parent::getPageData();
        return;
    }
}
