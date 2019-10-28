<?php
/**
 * Halo1FindUsView - Abstract model for the frontend Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1FindUsView extends Halo1AbstractFrontendView {

    public function renderContent($args){
        $page_data = $args['page_data'];
        $contacts_data = $args['contacts_config'];
        ?>
            <div class="col-xs-12">
                <div class="find-us-text">
                    <article>
                        <header>
                            <h1>
                                <?php echo $page_data['post_title']; ?>
                                <?php if(!empty($data['post_subtitle'])){?>
                                    <p class="subtitle"><?php echo $data['post_subtitle']?></p>
                                <?php } ?>
                            </h1>
                        </header>
                        <div class="row">
                            <div id="address-container" class="col-xs-12">
                                <?php if(isset($contacts_data ) && !empty($contacts_data['address']) && !empty($contacts_data['city'])){?>
                                <div id="map-container" >
                                    <div id="map-canvas"></div>
                                </div>
                                <section class="address">
                                    <header>
                                        <h3>
                                            <?php echo $contacts_data['company_name']; ?>
                                        </h3>
                                    </header>
                                    <div class="content">
                                        <p><?php echo $contacts_data['address']; ?></p>
                                        <p><?php echo $contacts_data['city']; ?></p>
                                        <p><?php echo $contacts_data['country']; ?></p>
                                    </div>
                                    <script>
                                        halo1_contacts_data = <?php echo json_encode($contacts_data); ?>;
                                        halo1_theme_path = <?php echo json_encode(get_stylesheet_directory_uri()); ?>;
                                    </script>
                                </section>
                                <?php }else{ ?>
                                <div id="map-message" >
                                    <?php _e('No valid address configuration.', 'Halo1');?>
                                </div>
                                <?php }?>
                            </div>
                            <div class="content-container col-xs-12">
                                <?php echo apply_filters('the_content',$page_data['post_content']); ?>
                            </div>
                        </div>
                    </article>
                </div>
            </div><!-- #main-column -->
        <?php
        return;
    }

    public function renderSearchForm($form){
        return parent::renderSearchForm($form);
    }

}
