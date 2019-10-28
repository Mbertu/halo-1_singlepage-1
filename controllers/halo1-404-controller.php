<?php
/**
 * Halo1404Controller
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1404Controller extends Halo1AbstractFrontendController {

    protected function getPageData(){
    	parent::getPageData();
        $this->page_model->setProperty('post_title', __('404 - Not Found', 'Halo1'));
        $this->page_model->setProperty('post_content', __('Sorry, but we can\'t find the content you are looking for.', 'Halo1'));
        $this->page_model->setProperty('home_url', get_home_url());
        $this->page_model->setProperty('home_link_label', __('Go back to Home Page.', 'Halo1'));
        $this->page_model->setProperty('show_breadcrumbs',true);
    }

}
