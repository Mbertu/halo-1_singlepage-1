<?php
/**
 * Halo1AbstractPluginConfigModel - Halo Abstract Configuraiton Model class
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractThemeConfigModel extends Halo1AbstractModel{

    /**
     * Method to init the model with input params or default values
     * @since <%= plugin_version_number %>
     */
    protected function init($args){
        $this->setProperty('version', isset($args['version']) ? $args['version'] : null );
        $this->setProperty('option_name', isset($args['option_name']) ? $args['option_name'] : null );
        $this->setProperty('page_name', isset($args['page_name']) ? $args['page_name'] : null );
        $this->import($this->defaults);
    }
}