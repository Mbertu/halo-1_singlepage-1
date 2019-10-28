<?php

class Halo1HomePageView extends Halo1AbstractFrontendView {

    public function renderContent($args){
        $page_data = $args['page_data'];    ?>

            <div class="home_widget_area">
                <?php $this->getWidgetArea( 'home_widget_area' ); ?>
            </div>
            <?php

        return;
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

}
