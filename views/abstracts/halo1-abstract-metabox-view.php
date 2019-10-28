<?php
/**
 * Halo1AbstractMetaboxView - Abstract metabox view for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractMetaboxView extends Halo1AbstractView{
    /**
     * Init of the view instance
     * @since 2.3.0
     * */
    protected function init($args){
    	return;
    }

    /**
     * Abstract, render the fields after title
     * @since 2.3.0
     */
    public abstract function renderFieldAfterTitle($args);

    /**
     * Abstract, render the metabox
     * @since 2.3.0
     */
    public abstract function renderMetabox($args);

    /**
     * Generate an input text field
     * @since 2.3.0
     * */
    protected function renderInput($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $message = isset($args['message']) ? $args['message'] : false;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

        $output = "<div class='".$id."_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output.= "'>";

        if(!empty($label)){
            $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
        }

        $output .= "<input id='".$id."' type='text' name='".$name."[".$id."]' value='".$value."' ";

        if(!$enabled)
            $output .= "disabled ";

        $output .= "/>";

        if($message)
            $output .= "<p class='description'>".$message."</p>";

        $output .= "</div>";
        echo $output;
    }

    /**
     * Generate an hidden input
     * @since 2.3.0
     * */
    protected function renderHidden($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];

        $output = "<input id='".$id."' type='hidden' name='".$name."[".$id."]' value='".$value."' />";
        echo $output;
    }
}