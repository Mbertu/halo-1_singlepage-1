<?php
/**
 * Halo1SearchView
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SearchView extends Halo1AbstractFrontendView {

    public function renderContent($args){
    	$data = $args['page_data'];
        ?>
            <div class="col-xs-12 col-md-9">
                    <header>
                        <h1 class="title">
                            <?php echo $data['search_title'];?>
                        </h1>
                        <?php if(!empty($data['post_subtitle'])){?>
                            <p class="subtitle"><?php echo $data['post_subtitle']?></p>
                        <?php } ?>
                    </header>
                    <div class="row">
                    <?php if(count($data['posts_list']) == 0){ ?>
                        <div class="col-xs-12">
                            <?php echo $data['empty_search_message']; ?>
                        </div>
                    <?php }
                    foreach($data['posts_list'] as $post){ ?>
                        <div class="custom-article col-xs-12 col-md-4 col-md-height-4 " itemscope itemtype="http://schema.org/Type" itemid="http://schema.org/BlogPosting" itemprop="blogPost">
                            <?php $this->renderArticle($post,$data['no_image']) ?>
                        </div>
                    <?php } ?>
                    </div>
                    <?php $this->renderPaginator($data['paginator_data']);?>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
                <?php $this->getWidgetArea( 'sidebar' ); ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

}
