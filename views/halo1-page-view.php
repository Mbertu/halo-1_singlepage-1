<?php
/**
 * Halo1PageView
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1PageView extends Halo1AbstractFrontendView {

    public function renderContent($args){
        $page_data = $args['page_data'];
        ?>
        <div id="page" class="container inside">
            <header class="post_header">
                <h2><?php echo $page_data['post_title'];?></h2>
                <?php if(!empty($page_data['post_subtitle'])){?>
                    <p><?php echo $page_data['post_subtitle']?></p>
                <?php } ?>
                <?php if($page_data['post_image']['posts-list']){ ?>
                <div class="post-image" itemprop="image">
                <?php echo $page_data['post_image']['posts-list']; ?>
                </div>
                <?php } ?>
            </header>
            <div class="post_content">
                <?php echo apply_filters('the_content',$page_data['post_content']);?>
            </div>
        </div>
        <?php
    }

    public function renderSearchForm($form){
      return parent::renderSearchForm($form);
    }

}
