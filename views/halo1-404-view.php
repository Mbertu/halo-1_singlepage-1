<?php
/**
 * Halo1404View
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1404View extends Halo1AbstractFrontendView {

    public function renderContent($args){
    	$data = $args['page_data'];
       	?>
        <div class="container">
            <div class="row">
                <div  class="col-xs-12">
                    <article class="page-container">
                        <header>
                            <h1 class="title">
                                <?php echo $data['post_title'];?>
                            </h1>
                        </header>
                        <div>
                            <div class="page-404">
                              <p>
                                404
                              </p>
                            </div>
                            <p>
                              <?php echo apply_filters('the_content',$data['post_content']); ?>
                              <a href="<?php echo $data['home_url']; ?>">
                                <?php echo $data['home_link_label']?>
                              </a>
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <?php
        return;
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

}
