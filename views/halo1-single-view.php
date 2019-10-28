<?php
/**
 * Halo1SingleView
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SingleView extends Halo1AbstractFrontendView {

    public function renderContent($args){
        $page_data = $args['page_data'];
        if($page_data['post_format'] == "standard"){
            $this->renderStandardPostView($page_data);
            // if( ## check post-type ##){
            //
            // }else{
            //
            // }
        }else if($page_data['post_format'] == "gallery"){
            $this->renderGalleryPostView($page_data);
        }else if($page_data['post_format'] == "video"){
            $this->renderVideoPostView($page_data);
        }else if($page_data['post_format'] == "link"){
            $this->renderLinkPostView($page_data);
        }else if($page_data['post_format'] == "image"){
            $this->renderLinkPostView($page_data);
        }
    }

    private function renderStandardPostView($page_data){
        ?>
            <div class="col-xs-12 col-md-9">
                <article>
                    <header>
                        <h1 class="title"><?php echo $page_data['post_title'];?></h1>
                        <?php if(!empty($page_data['post_subtitle'])){?>
                            <p class="subtitle"><?php echo $page_data['post_subtitle']?></p>
                        <?php } ?>

                        <?php if($page_data['post_image']['full']){ ?>
                        <div class="post-image" itemprop="image">
                        <?php echo $page_data['post_image']['full']; ?>
                        </div>
                        <?php } ?>
                        <div class="post-meta-info">
                            <?php echo $this->getPostMeta($page_data['author'], $page_data['post_date']);?>
                        </div>
                    </header>
                    <div id="post-<?php echo $page_data['post_id'];?>" class="content">
                        <?php echo apply_filters('the_content',$page_data['post_content']);?>
                    </div>
                    <?php $this->getSingleArticleFooter($page_data['post_category'], $page_data['tags_input'], $page_data['post_navigation']);?>
                </article>
                <?php if(!empty($page_data['comments_data'])){
                    echo $this->renderComments($page_data['comments_data'],$page_data['post_id']);
                } ?>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
            <?php
                $this->getWidgetArea( 'sidebar' );
            ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    private function renderGalleryPostView($page_data){
        ?>
          <div class="col-xs-12 col-md-9">
                <article>
                    <header>
                        <h1 class="title"><?php echo $page_data['post_title'];?></h1>
                        <div class="post-meta-info">
                            <?php echo $this->getPostMeta($page_data['author'], $page_data['post_date']);?>
                        </div>
                        <?php if($page_data['post_image']['posts-list']){ ?>
                        <div class="post-image" itemprop="image">
                        <?php echo $page_data['post_image']['posts-list']; ?>
                        </div>
                        <?php } ?>
                    </header>
                    <div id="post-<?php echo $page_data['post_id'];?>" class="content">
                        <?php echo apply_filters('the_content',$page_data['post_content']);?>
                    </div>
                    <?php $this->getSingleArticleFooter($page_data['post_category'], $page_data['tags_input'], $page_data['post_navigation']);?>
                </article>
                <?php if(!empty($page_data['comments_data'])){
                    echo $this->renderComments($page_data['comments_data'],$page_data['post_id']);
                } ?>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
            <?php
                $this->getWidgetArea( 'sidebar' );
            ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    private function renderVideoPostView($page_data){
        ?>
            <div class="col-xs-12 col-md-9">
                <article>
                    <header>
                        <h1 class="title"><?php echo $page_data['post_title'];?></h1>
                        <div class="post-meta-info">
                            <?php echo $this->getPostMeta($page_data['author'], $page_data['post_date']);?>
                        </div>
                        <?php if($page_data['post_image']['posts-list']){ ?>
                        <div class="post-image" itemprop="image">
                        <?php echo $page_data['post_image']['posts-list']; ?>
                        </div>
                        <?php } ?>
                    </header>
                    <div id="post-<?php echo $page_data['post_id'];?>" class="content">
                        <?php echo apply_filters('the_content',$page_data['post_content']);?>
                    </div>
                    <?php $this->getSingleArticleFooter($page_data['post_category'], $page_data['tags_input'], $page_data['post_navigation'], $page_data['post_navigation']);?>
                </article>
                <?php if(!empty($page_data['comments_data'])){
                    echo $this->renderComments($page_data['comments_data'],$page_data['post_id']);
                } ?>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
            <?php
                $this->getWidgetArea( 'sidebar' );
            ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    private function renderLinkPostView($page_data){
        ?>
            <div class="col-xs-12 col-md-9">
                <article>
                    <header>
                        <h1 class="title"><?php echo $page_data['post_title'];?></h1>
                        <div class="post-meta-info">
                            <?php echo $this->getPostMeta($page_data['author'], $page_data['post_date']);?>
                        </div>
                        <?php if($page_data['post_image']['posts-list']){ ?>
                        <div class="post-image" itemprop="image">
                        <?php echo $page_data['post_image']['posts-list']; ?>
                        </div>
                        <?php } ?>
                    </header>
                    <div id="post-<?php echo $page_data['post_id'];?>" class="content">
                        <?php echo apply_filters('the_content',$page_data['post_content']);?>
                    </div>
                    <?php $this->getSingleArticleFooter($page_data['post_category'], $page_data['tags_input'], $page_data['post_navigation']);?>
                </article>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
            <?php
                $this->getWidgetArea( 'sidebar' );
            ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    private function renderImagePostView($page_data){
        ?>
            <div class="col-xs-12 col-md-9">
                <article>
                    <header>
                        <h1 class="title"><?php echo $page_data['post_title'];?></h1>
                        <div class="post-meta-info">
                            <?php echo $this->getPostMeta($page_data['author'], $page_data['post_date']);?>
                        </div>
                        <?php if($page_data['post_image']['posts-list']){ ?>
                        <div class="post-image" itemprop="image">
                        <?php echo $page_data['post_image']['posts-list']; ?>
                        </div>
                        <?php } ?>
                    </header>
                    <div id="post-<?php echo $page_data['post_id'];?>" class="content">
                        <?php echo apply_filters('the_content',$page_data['post_content']);?>
                    </div>
                    <?php $this->getSingleArticleFooter($page_data['post_category'], $page_data['tags_input'], $page_data['post_navigation']);?>
                </article>
                <?php if(!empty($page_data['comments_data'])){
                    echo $this->renderComments($page_data['comments_data'],$page_data['post_id']);
                } ?>
            </div><!-- #main-column -->
            <div id="right-sidebar" class="col-xs-12 col-md-3">
            <?php
                $this->getWidgetArea( 'sidebar' );
            ?>
            </div><!-- #left-sidebar -->
        <?php
    }

    protected function getSingleArticleFooter($categories, $tags, $post_navigation){
        ?>
        <footer>
          <div class="footer-article ">

          <div class="row">
              <div class="col-xs-6 footer_section">
                <?php if($categories != ''){ ?>
                <div class="footer_section_title"><?php _e('Categories','Halo1');?></div>
                  <?php
                    if(count($n=explode(',',$categories))>3){
                    echo $n[0].','.$n[1].','.$n[2].' ...';
                  } else {
                    echo $categories;
                  }
                } ?>
                </div>
                <div class="col-xs-6 footer_section">
                  <?php if($tags != ''){ ?>
                  <div class="footer_section_title"><?php _e('Tags','Halo1');?></div>
                  <?php
                    if(count($n=explode(',',$tags))>3){
                    echo $n[0].','.$n[1].','.$n[2]. '...';
                  } else {
                    echo $tags;
                  }
                } ?>
              </div>
            </div>
          </div>
          <div class="post-navigation">
          <div class="row">
                <?php if(!empty($post_navigation) && !is_null($post_navigation)){ ?>
                    <?php $this->renderPostsPaginator($post_navigation); ?>
                <?php } ?>
            </div>
          </div>
        </footer>
        <?php
    }

    private function renderPostsPaginator($post_navigation){
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 navigation text-left">
                <?php if(!is_null($post_navigation['prev'])){?>
                <a  href="<?php echo $post_navigation['prev']['permalink'];?>">
                    <span class="icon icon-navigation icon-arrow-left"></span>
                    <?php echo $post_navigation['prev']['label'];?>
                </a>
                <?php } ?>
            </div>
            <div class="col-xs-12 col-sm-6 navigation text-right">
                <?php if(!is_null($post_navigation['next'])){?>
                <a  href="<?php echo $post_navigation['next']['permalink'];?>">
                    <?php echo $post_navigation['next']['label'];?>
                    <span class="icon icon-navigation icon-arrow-right"></span>
                </a>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

}
