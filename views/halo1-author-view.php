<?php
/**
 * Halo1AuthorView
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1AuthorView extends Halo1AbstractFrontendView {

    public function renderContent($args){
    	$data = $args['page_data'];
        ?>
            <div class="col-xs-12 col-md-9">
                    <header>
                        <h1 class="title">
                            <?php echo $data['display_name'];?>
                        </h1>
                    </header>
                    <?php if(!empty($data['user_description'])){ ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="description"><?php echo $data['user_description'];?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                    <?php if(count($data['posts_list']) == 0){ ?>
                        <div class="col-xs-12">
                            <?php echo $data['empty_list_message']; ?>
                        </div>
                    <?php }
                    foreach($data['posts_list'] as $post){ ?>
                      <div class="custom-article col-xs-12 col-md-4 col-md-height-4"  itemscope itemtype="http://schema.org/Type" itemid="http://schema.org/BlogPosting" itemprop="blogPost">
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
        return;
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

    private function getAuthorContacts($socials = null, $email = null, $url = null){
        $output = '';
        if(!empty($email['email'])){
            $output .= '<div class="col-xs-12">';
            $output .= '<a href="mailto:'.$email['email'].'">'.$email['label'].'</a>';
            $output .= '</div>';
        }
        if(!empty($url['url'])){
            $output .= '<div class="col-xs-12">';
            $output .= '<a href="'.$url['url'].'" target="_blank" rel="no-follow">'.$url['label'].'</a>';
            $output .= '</div>';
        }
        if(!empty($socials)){
            if(!empty($socials['facebook']['url'])){
                $output .= '<div class="col-xs-12">';
                $output .= '<a href="'.$socials['facebook']['url'].'" target="_blank" rel="no-follow">'.$socials['facebook']['label'].'</a>';
                $output .= '</div>';
            }
            if(!empty($socials['twitter']['url'])){
                $output .= '<div class="col-xs-12">';
                $output .= '<a href="'.$socials['twitter']['url'].'" target="_blank" rel="no-follow">'.$socials['twitter']['label'].'</a>';
                $output .= '</div>';
            }
            if(!empty($socials['googleplus']['url'])){
                $output .= '<div class="col-xs-12">';
                $output .= '<a href="'.$socials['googleplus']['url'].'" target="_blank" rel="no-follow">'.$socials['googleplus']['label'].'</a>';
                $output .= '</div>';
            }
        }
        return $output;
    }

}
