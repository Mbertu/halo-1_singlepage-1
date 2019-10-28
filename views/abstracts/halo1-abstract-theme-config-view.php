<?php
/**
 * Halo1AbstractThemeConfigView - Abstract theme config view for the Halo structure
 */
abstract class Halo1AbstractThemeConfigView extends Halo1AbstractView{

    public function render($args){
        if(empty($args)){
            return;
        }

        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( $args['permission_error_message'] );
        }
        echo sprintf("<div class=\"wrap\"><h2>%s</h2><form id='%s' method=\"post\" action=\"options.php\" enctype=\"multipart/form-data\">",
                    $args['title'],
                    $args['form_id']);
        settings_errors();
        settings_fields( $args['fields'] );
        do_settings_sections( $args['sections'] );
        submit_button();
        echo    "</form></div>";
    }

    /**
     * Generate an input text field
     * @since <%= plugin_version_number %>
     * */
    public function renderInput($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $message = isset($args['message']) ? $args['message'] : false;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

        $output = "<div class='".$id."_container halo8_input_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output.= "'>";

        $output .= "<input id='".$id."' type='text' name='".$name."[".$id."]' value='".$value."' ";

        if(!$enabled)
            $output .= "disabled ";

        $output .= "/>";

        if(!empty($label)){
            $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
        }

        if($message)
            $output .= "<p class='description'>".$message."</p>";

        $output .= "</div>";
        echo $output;
    }

    /**
     * Generate an hidden input
     * @since <%= plugin_version_number %>
     * */
    public function renderHidden($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];

        $output = "<input id='".$id."' type='hidden' name='".$name."[".$id."]' value='".$value."' />";
        echo $output;
    }

    /**
     * Generate a checkbox input
     * @since <%= plugin_version_number %>
     * */
    public function renderCheckbox($args) {
        $id = $args['id'];
        $name = $args['name'];
        $checked = $args['checked'];
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $message = isset($args['message']) ? $args['message'] : false;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

        $output = "<div class='".$id."_container halo8_input_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output.= "'>";

        $output .= "<input id='".$id."' name='".$name."[".$id."]' type='checkbox' value='true' ";
        if($checked)
            $output .= "checked='checked' ";
        if(!$enabled)
            $output .= "disabled ";
        $output .= "/>";
        if(!empty($label)){
            $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
        }
        if($message)
            $output .= "<p class='description'>".$message."</p>";

        $output .= "</div>";
        echo $output;
    }

    /**
     * Generate a radio button
     * @since <%= plugin_version_number %>
     * */
    public function renderRadio($args) {
        $id = $args['id'];
        $name = $args['name'];
        $elements = $args['elements'];
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

        $output = "<div class='".$id."_container halo8_input_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output.= "'>";

        foreach($elements as $element){
            $output .= "<p><label><input type='radio' name='".$name."[".$id."]' value='".$element['value']."' class='tog ".$id."' ";
            if($element['checked'])
                $output .= "checked='checked' ";
            if(!$enabled)
                $output .= "disabled ";
            $output .= "/>".$element['label']."</label></p>";
        }
        $output .= "</div>";
        echo $output;
    }

    /**
     * Generate a select input
     * @since <%= plugin_version_number %>
     * */
    public function renderSelect($args) {
        $id = $args['id'];
        $name = $args['name'];
        $elements = $args['elements'];
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $message = isset($args['message']) ? $args['message'] : false;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

        $output = "<div class='".$id."_container halo8_input_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output.= "'>";

        $output .= "<select id='".$id."' name='".$name."[".$id."]' ";
        if(!$enabled)
            $output .= "disabled ";
        $output .= ">";
        foreach($elements as $element){
            $output .= "<option value='".$element['value']."'";
            if($element['current'])
                $output .= "selected";
            $output .= ">".$element['label']."</option>";
        }
        $output .= "</select>";

        if(!empty($label)){
            $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
        }

        if($message)
            $output .= "<p class='description'>".$message."</p>";

        $output .= "</div>";
        echo $output;
    }

    /**
     * Generate a button
     * @since <%= plugin_version_number %>
     * */
    public function renderButton($args) {
        $id = $args['id'];
        $name = $args['name'];
        $message = isset($args['message']) ? $args['message'] : false;

        $output = "<a id='".$id."'class='".$args['button_classes']."' href='#'>".$name."</a>";
        if($message)
            $output .= "<p class='description'>".$message."</p>";
        echo $output;
    }

    /**
     * Generate an input file
     * @since <%= plugin_version_number %>
     * */
    public function renderInputFile($args){
        $id = $args['id'];
        $name = $args['name'];
        $value = $args['value'];
        $isDefault = (isset($args['isDefault']) && !empty($args['isDefault'])) ? $args['isDefault'] : false;
        $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
        $enabled = isset($args['enabled']) ? $args['enabled'] : true;
        $message = isset($args['message']) ? $args['message'] : false;
        $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();
        $delete_button_text = isset($args['delete_button_text']) ? $args['delete_button_text'] : 'Delete';

        $output = "<div class='".$id."_container halo1_input_container";
        foreach ($extra_classes as $class) {
            $output .= ' '.$class;
        }
        $output .= "'>";

        $output .= "<input id='".$id."' type='file' name='".$id."'";

        if(!$enabled)
            $output .= "disabled ";

        $output .= "/>";

        if(isset($value) && !empty($value))
        {
            $output .= '<img src="' . $value . '" style="max-width: 100px; vertical-align: top;" /><br/>';
            if(!$isDefault){
                $output .= '<input id="'.$id.'_reset" type="submit" class="button button-primary" value="'.$delete_button_text.'">';
            }
        }

        if(!empty($label)){
            $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
        }

        if($message)
            $output .= "<p class='description'>".$message."</p>";

        $output .= "</div>";
        echo $output;
    }
}