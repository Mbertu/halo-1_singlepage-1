<?php
/**
 * Halo1SubtitleMetaboxController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SubtitleMetaboxController extends Halo1AbstractMetaboxController {
    /**
     * Flag that to switch between metabox and after_title_field
     * @var boolean
     */
    private $is_field_after_title = false;

    /**
     * Render the subtitle metabox view.
     * @since 2.3.0
     */
    public function renderView($only = false){
        if(is_null($this->getProperty('current_page')))
            return;
        if($this->getFieldAfterTitle()){
            $this->renderSubtitleField();
            return;
        }else{
            add_meta_box(
                'halo1_'.$this->getProperty('model')->getProperty('option_name'),
                'Subtitle',
                array($this, 'renderSubtitleMetabox'),
                $this->getProperty('current_page'),
                'normal',
                'high'
            );
        }
    }

    /**
     * SET the $is_field_after_title flag
     * @since 2.3.0
     */
    public function setFieldAfterTitle($flag){
        $this->is_field_after_title = $flag;
    }

    /**
     * GET the $is_field_after_title flag
     * @since 2.3.0
     */
    public function getFieldAfterTitle(){
        return $this->is_field_after_title;
    }

    /**
     * Render the subtitle input field.
     * @since 2.3.0
     */
    public function renderSubtitleField(){
        $args = $this->getViewArgs();
        $this->getProperty('view')->renderFieldAfterTitle($args);
    }

    /**
     * Render the subtitle input field.
     * @since 2.3.0
     */
    public function renderSubtitleMetabox($current_post){
        $this->getMetaboxData($current_post->ID);
        $args = $this->getViewArgs();
        $this->getProperty('view')->renderMetabox($args);
    }

    /**
     * Save subtitle metadata
     * @since 2.3.0
     */
    public function saveMetadata($args){
        $post_id = $args['post_id'];
        $_post = $args['_post'];

        // Controllo che ci sia un nonce settato
        if (!isset($_post['halo1_nonce'])){
            return;
        }

        // Controllo che il nonce sia quello che mi aspetto
        if(!wp_verify_nonce($_post['halo1_nonce'], $this->getProperty('nonce_phrase'))){
            return;
        }

        // Check the user's permissions.
        if ( isset( $_post['post_type'] ) && ('page' == $_post['post_type'] || 'post' == $_post['post_type'])) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        }

        /* OK, its safe for us to save the data now. */
        if(isset($_post[$this->getProperty('model')->getProperty('option_name')])){
            $_post[$this->getProperty('model')->getProperty('option_name')]['subtitle'] = sanitize_text_field($_post[$this->getProperty('model')->getProperty('option_name')]['subtitle']);

            $this->getProperty('model')->import($_post[$this->getProperty('model')->getProperty('option_name')]);
            // Update the meta field in the database.
            update_post_meta( $post_id, $this->getProperty('model')->getProperty('option_name'), $this->getProperty('model')->toArray() );
        }
        return;
    }

    /**
     * Get the metabox for the current post
     * @since 2.3.0
     */
    public function getMetaboxData($post_id){
        $value = get_metadata('post', $post_id, $this->getProperty('model')->getProperty('option_name'), true);
        $this->getProperty('model')->import($value);
    }

    /**
     * Compile the args array for the view
     * @since 2.3.0
     */
    private function getViewArgs(){
        $args = array(
            'elements' => array(
                array(
                    'type' => 'nonce',
                    'nonce_phrase' => $this->nonce_phrase,
                    'prefix' => 'halo1_'
                ),
                array(
                    'type' => 'input',
                    'id' => 'subtitle',
                    'label' => __('Input here the subtitle', 'Halo1'),
                    'prefix' => 'halo1_',
                    'name' => $this->getProperty('model')->getProperty('option_name'),
                    'value' => htmlentities($this->getProperty('model')->getProperty('subtitle'), ENT_QUOTES)
                )
            )
        );
        return $args;
    }
}
