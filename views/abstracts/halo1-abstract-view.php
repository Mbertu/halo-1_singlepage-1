<?php
/**
 * Halo1AbstractView - Abstract view for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractView{

	/**
     * View contructor
     * @since <%= plugin_version_number %>
     * */
    protected function __construct() {}

    /**
     * Method to get an instance of the current child view
     * @since <%= plugin_version_number %>
     * */
    public static function getInstance($className, $args) {
        if (!function_exists('get_called_class')) {
            $c = $className;
        }else{
            $c = get_called_class();
        }

        $instance = new $c();
        $instance->init($args);

        return $instance;
    }

	/**
     * Init the current instance saving the plugin url
     * @since <%= plugin_version_number %>
     * */
    protected abstract function init($args);
}