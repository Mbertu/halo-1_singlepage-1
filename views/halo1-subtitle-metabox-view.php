<?php
/**
 * Halo1SubtitleMetaboxView - Subtitle field metabox view
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SubtitleMetaboxView extends Halo1AbstractMetaboxView {

	/**
     * Render the fields after title
     * @since 2.3.0
     */
    public function renderFieldAfterTitle($args = NULL){
        if(!isset($args['elements']) || empty($args['elements']))
            return;

        foreach ($args['elements'] as $element) {
            switch($element['type']){
                case 'checkbox':
                    $this->renderCheckbox($element);
                break;
                case 'input':
                    $this->renderInputAfterTitle($element);
                break;
                case 'select':
                    $this->renderSelect($element);
                break;
                case 'radio':
                    $this->renderRadio($element);
                break;
                case 'nonce':
                    wp_nonce_field( $element['nonce_phrase'], $element['prefix'].'nonce' );
                break;
            }
        }
    }

    /**
     * Render the metabox
     * @since 2.3.0
     */
    public function renderMetabox($args = NULL){
        if(!isset($args['elements']) || empty($args['elements']))
            return;

        foreach ($args['elements'] as $element) {
            switch($element['type']){
                case 'checkbox':
                    $this->renderCheckbox($element);
                break;
                case 'input':
                    $this->renderInput($element);
                break;
                case 'select':
                    $this->renderSelect($element);
                break;
                case 'radio':
                    $this->renderRadio($element);
                break;
                case 'nonce':
                    wp_nonce_field( $element['nonce_phrase'], $element['prefix'].'nonce' );
                break;
            }
        }
    }

    /**
     * Render Input Field after title
     * @since 2.3.0
     */
    private function renderInputAfterTitle($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';

        $output = "<div class='".$id."_container container_after_title'>";
        $output .= "<label id='subtitle-prompt-text' ";
        if(!empty($value))
            $output .= "class='screen-reader-text' ";
        $output .= "for='".$id."'>".$label."</label>";
        $output .= "<input id='".$id."' class='field_after_title' type='text' name='".$name."[".$id."]' value='".$value."' size='30' spellcheck='true' autocomplete='off' />";
        $output .= "</div>";
        echo $output;
    }
}