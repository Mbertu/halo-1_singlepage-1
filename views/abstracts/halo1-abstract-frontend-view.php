<?php
/**
 * Halo1AbstractFrontendView - Abstract view for the frontend Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractFrontendView extends Halo1AbstractView{

    public function init($args){
        return;
    }


    /**
     * Abstract, render header method for the view
     * @since 2.0.0
     * */
    public function renderHeader($args){
        $socials_config = $args['socials_config'];
        $contacts_config = $args['contacts_config'];
        $page_data = $args['page_data'];
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
            <head>
                <meta charset="<?php echo $page_data['site_charset'] ?>">
                <meta name="viewport" content="width=device-width">

                <title><?php wp_title( '|', true, 'right' ); ?></title>



                <link rel="profile" href="http://gmpg.org/xfn/11">
                <!--[if lt IE 9]>
                <script src="<?php echo $page_data['html5shiv_js'] ?>"></script>
                <![endif]-->
                <?php wp_head(); ?>
            </head>
            <body <?php body_class(); ?> itemscope itemtype="http://schema.org/Type" itemid="http://schema.org/Blog">
                <div id="page_container">
                    <header id="header" role="banner">
                        <div class="site-logo-container">
                            <div class="container">
                                <div class="row">
                                  <?php if(function_exists('icl_get_languages')){ ?>
                                      <div class="col-xs-6 col-md-offset-3 text-center">
                                          <div class="site-logo">
                                              <?php echo $page_data['site_logo'];?>
                                          </div>
                                      </div>
                                      <div class="col-xs-6 col-md-3 text-right">
                                            <div class="lang-switch-container">
                                                <?php $this->renderLangSwitcher(); ?>
                                            </div>
                                      </div>
                                      <?php } else { ?>
                                        <div class="col-xs-12 text-center">
                                            <div class="site-logo">
                                                <?php echo $page_data['site_logo'];?>
                                            </div>
                                        </div>
                                      <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div id="halo8_container"></div>

                        <?php
                            $menu_data = $page_data['menu_data']['main'];
                            if(!is_home() && !is_front_page()){
                                $menu_data = $page_data['menu_data']['pages'];
                            }
                            $this->renderHeaderMenu($menu_data);
                            ?>
                    </header>

                    <div id="content" class="hfeed site">
                          <?php echo $this->renderSeparator($page_data['site_separator'],'header'); ?>
                          <?php echo $this->renderBreadcrumbs(); ?>

    <?php
    }

    /**
     * Render footer method for the view
     * @since 2.0.0
     * */
    public function renderFooter($args){
        $socials_config = $args['socials_config'];
        $contacts_config = $args['contacts_config'];
        $page_data = $args['page_data'];
        echo $this->renderSeparator($page_data['site_separator'],'footer');
        ?>


                    </div>

                    <footer id="footer" role="contentinfo">
                        <?php if(!empty($page_data['footer_socials'])){?>
                            <div class="footer_socials_container">
                              <div class="container">
                                <div class="row">
                                  <div class="footer_socials_row clearfix">
                                      <div class="col-xs-12">
                                          <?php echo apply_filters('the_content',$page_data['footer_socials']); ?>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php } ?>

                      <?php if(!empty($page_data['footer_info']) || !empty($page_data['menu_data']['privacy'])){?>
                          <div class="footer_info_container">
                            <div class="container">
                              <div class="row">
                                <div class="footer_info_row clearfix">
                                    <div class="col-xs-12">
                                        <?php if(!empty($page_data['footer_info'])){
                                            echo $page_data['footer_info'];
                                            if(!empty($page_data['menu_data']['privacy'])){ ?>
                                                <div class="separator"></div>
                                            <?php }
                                        }
                                        if(!empty($page_data['menu_data']['privacy'])){
                                             $this->renderPrivacyMenu($page_data['menu_data']['privacy']);
                                        } ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <?php } ?>

                      <?php if(!empty($page_data['footer_disclaimer'])){?>
                          <div class="footer_disclaimer_container">
                            <div class="container">
                              <div class="row">
                                <div class="footer_disclaimer_row clearfix">
                                    <div class="col-xs-12">
                                        <?php echo $page_data['footer_disclaimer']; ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <?php } ?>

                      <?php if(!empty($page_data['footer_signature'])){?>
                          <div class="footer_signature_container">
                            <div class="container">
                              <div class="row">
                                <div class="footer_signature_row clearfix">
                                    <div class="col-xs-12">
                                        <?php echo $page_data['footer_signature']; ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <?php } ?>




                    </footer>
                </div> <!-- /#page-container-->
                <?php wp_footer(); ?>
            </body>
        </html>
        <?php
        return;
    }

     /**
     * Render the socials block
     * @since 2.0.0
     */
     protected function renderSocialBlock($socials){
        if($socials['facebook_url']){
          ?><a href="<?php echo $socials['facebook_url'];?>" rel="no-follow" target="_blank"><i class="icon icon-facebook-square icon-lg" aria-hidden="true"></i></a><?php }
        if($socials['twitter_url']){
          ?><a href="<?php echo $socials['twitter_url']; ?>" rel="no-follow" target="_blank"><i class="icon icon-twitter-square icon-lg" aria-hidden="true"></i></a><?php }
        if($socials['instagram_url']){
          ?><a href="<?php echo $socials['instagram_url']; ?>" rel="no-follow" target="_blank"><i class="icon icon-instagram icon-lg" aria-hidden="true"></i></a><?php }
        if($socials['pinterest_url']){
          ?><a href="<?php echo $socials['pinterest_url']; ?>" rel="no-follow" target="_blank"><i class="icon icon-pinterest-square icon-lg" aria-hidden="true"></i></a><?php }
        if($socials['youtube_url']){
          ?><a href="<?php echo $socials['youtube_url']; ?>" rel="no-follow" target="_blank"><i class="icon icon-youtube-play icon-lg" aria-hidden="true"></i></a><?php }
        if($socials['google_plus_url']){
          ?><a href="<?php echo $socials['google_plus_url']; ?>" rel="no-follow" target="_blank"><i class="icon icon-google-plus-square icon-lg" aria-hidden="true"></i></a><?php }
     }

     private function renderHeaderMenu($data){
         if(empty($data)) return; ?>
         <div class="header_menu_outer_container">
             <div class="container header_menu_inner_container">
                 <nav class="row" role="navigation">
                     <div class="header_menu_mobile_inner_container hidden-md hidden-lg">
                         <div class="btn header_menu_toggle collapsed" data-toggle="collapse" data-target="#header_menu">
                             <i class="icon icon-bars" aria-hidden="false"></i>
                             <i class="icon icon-times" aria-hidden="false"></i>
                             <span><?php _e('Menu','Halo1'); ?></span>
                         </div>
                     </div>
                    <?php wp_nav_menu(array(
                       'theme_location' => $data['menu_id'],
                       'container_id' => $data['menu_id'].'-menu',
                       'menu_class' => 'collapse',
                       'menu_id' =>'header_menu',
                       'items_wrap' => $data['items_wrap'],
                       'depth' => 3,
                       'walker' => $data['walker']
                    )); ?>
                </nav>
            </div>
        </div>
         <div class="header_menu_trigger"></div>
        <?php
     }

    protected function renderLangSwitcher(){
        $languages = icl_get_languages('skip_missing=0&orderby=custom&order=asc&link_empty_to={%lang}');
        if(1 < count($languages)){
            foreach($languages as $l){
                if(isset($l['missing']) && $l['missing']){
                    $flag = '<span class="lang-link-container"><a href="/'.$l['url'].'" ';
                }else{
                    $flag = '<span class="lang-link-container"><a href="'.$l['url'].'" ';
                }
                //$flag = '<div class="lang-link-container"><a href="'.$l['url'].'" ';
                if($l['active']){
                    $flag .= 'class="active" ';
                }
                $flag .= '>';
                $flag .= $l['language_code'].'</a></span>';
                $langs[] = $flag;
            }
            echo join('', $langs);
        }
    }


    protected function renderPrivacyMenu($data){
        if(empty($data)) return;  ?>
                <nav class="privacy-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <?php wp_nav_menu(array(
                        'theme_location' => $data['menu_id'],
                        'container_id' => $data['menu_id'].'-menu',
                        'menu_class' => '',
                        'items_wrap' => $data['items_wrap'],
                        'depth' => 1,
                        'walker' => $data['walker']
                    )); ?>
                </nav>

        <?php
    }

    protected function renderRetorica(){
        $output = '<a href="http://www.retorica.net" rel="no-follow" target="_blank" title="Retorica Comunicazione"><img src="'.get_bloginfo('template_directory').'/assets/images/retorica-logo.png" /></a>';
        return $output;
    }

	/**
     * Render the paginator
     * @since 2.1.0
     * */
    protected function renderPaginator($paginator_data) {
      if(empty($paginator_data['links'])){
        return;
      }
        ?>
        <nav class="navigation paginator" role="navigation">
            <ul>
            <?php if(isset($paginator_data['first_link'])){ ?>
                <li>
                    <a href="<?php echo $paginator_data['first_link'];?>"><?php _e('First','Halo1');?></a>
                </li>
            <?php } ?>
            <?php if(isset($paginator_data['prev_link'])){ ?>
                <li>
                    <?php echo $paginator_data['prev_link'];?>
                </li>
            <?php } ?>

            <?php foreach($paginator_data['links'] as $page => $link){
                if($link == 'active'){ ?>
                    <li class="active">
                        <a href="#"><?php echo $page; ?></a>
                    </li>
                <?php }else{ ?>
                    <li>
                        <a href="<?php echo $link; ?>"><?php echo $page; ?></a>
                    </li>
                <?php }
            } ?>
            <?php if(isset($paginator_data['next_link'])){ ?>
                <li>
                    <?php echo $paginator_data['next_link'];?>
                </li>
            <?php } ?>
            <?php if(isset($paginator_data['last_link'])){ ?>
                <li>
                    <a href="<?php echo $paginator_data['last_link'];?>"><?php _e('Last','Halo1');?></a>
                </li>
            <?php } ?>
            </ul>
        </nav>
        <?php
    }

    /**
     * Render the comment block
     * @since 2.7.0
     */
    protected function renderComments($comments_data, $post_id){
    ?>
        <div id="comments" class="comments-area">
            <?php if($comments_data['count'] || false){?>
                <h2 class="comments-title">
                    <?php
                        echo __('Comments:', 'Halo1').' <i class="icon icon-comments"></i>'.$comments_data['count'];
                    ?>
                </h2>

                <?php if(isset($comments_data['max_num_pages']) && $comments_data['max_num_pages'] > 1){?>
                <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php _e( 'Comment navigation','Halo1' ); ?></h1>
                    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments','Halo1' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;','Halo1' ) ); ?></div>
                </nav><!-- #comment-nav-above -->
                <?php } ?>

                <ul class="comment-list">
                    <?php
                        wp_list_comments( array(
                            'walker'        => $comments_data['walker'],
                            'style'         => 'ul',
                            'short_ping'    => false,
                            'avatar_size'   => 64,
                        ), $comments_data['commentsList'] );
                    ?>
                </ul><!-- .comment-list -->

                <?php if(isset($comments_data['max_num_pages']) && $comments_data['max_num_pages'] > 1){?>
                <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php _e( 'Comment navigation','Halo1' ); ?></h1>
                    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments','Halo1' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;','Halo1' ) ); ?></div>
                </nav><!-- #comment-nav-above -->
                <?php } ?>

                <?php if(!comments_open($post_id)){?>
                <p class="no-comments"><?php _e( 'Comments are closed.','Halo1' ); ?></p>
                <?php } ?>

            <?php } ?>

            <?php
                $args = array('title_reply' => __('Leave a Reply', 'Halo1'));
                comment_form($args, $post_id);
            ?>
        </div><!-- #comments -->
        <?php
    }



    protected function getWidgetArea($id){
        dynamic_sidebar( $id );
    }


    protected function getPostMeta($author, $date){
        $meta_data = "<i><span>".__('Posted by', 'Halo1')." <span itemscope itemtype=\"http://schema.org/Type\" itemid=\"http://schema.org/Person\" itemprop=\"author\"><a href=\""
                    .$author['permalink']."\" itemprop=\"name\">".$author['name']."</a></span> "
                    .__('on', 'Halo1')." <span itemprop=\"datePublished\">".date_i18n(get_option( 'date_format' ),strtotime($date))."</span></span></i>";
        return $meta_data;
    }

    protected  function renderSearchForm($form){
      ?>
        <form role="search" method="get" class="search-form clearfix" action="<?php echo home_url( '/' ); ?>">
            <label>
                <span class="screen-reader-text"><?php _e( 'Search for:', 'Halo1' ); ?></span>
                <input type="search" class="form-control search-field" placeholder="<?php _e( 'Search...', 'Halo1' );?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php  _e( 'Search for:', 'Halo1' ) ?>" />
            </label>
            <button type="submit" class="btn btn-1"><i class="icon icon-search"></i></button>
        </form>
      <?
    }

    protected function getArticleFooter($categories, $tags){
        ?>
        <div class="footer-article">
        <div class="row">
            <div class="col-xs-6  footer_section">
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
                  echo $n[0].','.$n[1].','.$n[2].' ...';
                } else {
                  echo $tags;
                }
              } ?>
            </div>
        </div>
      </div>
        <?php
    }



    /**
     * Create a string of class from an array
     * @return String
     * @since  2.6.3
     */
    protected function renderPostClass($classes){
        $string = '';
        if(empty($classes)){
            return $string;
        }
        foreach($classes as $class){
            $string .= $class.' ';
        }
        return trim($string);
    }

    protected function renderSeparator($separator,$position){
      if(!empty($separator)){
        $url ='url('.$separator.')';
        $height = get_theme_mod('separator_height').'px';
        if($position==='header'){
          $margin = get_theme_mod('separator_margin').'px 0 0 0';
        } else {
          $margin = ' 0 0 '. get_theme_mod('separator_margin').'px  0';
        }
        if(1==get_theme_mod('separator_repeat')){
          $repeat='repeat-x';
          $size="auto";
        } else {
          $repeat='no-repeat';
          $size="100% auto";
        } ?>

        <div id="separator" style="height:<?php echo $height;?>;
                                   margin:<?php echo $margin;?>;
                                   background-image:<?php echo $url;?>;
                                   background-size:<?php echo $size;?>;
                                   background-repeat:<?php echo $repeat;?>;">
       </div>
        <?php }
    }

    protected function renderBreadcrumbs(){
       if (function_exists('yoast_breadcrumb') && !is_home() && !is_front_page() ) {
            yoast_breadcrumb('<div id="breadcrumbs" class="container inside"><p>','</p></div>');
      }
    }



    /**
     * Abstract, render content method for the view
     * @since <%= plugin_version_number %>
     * */
    public abstract function renderContent($args);
}
