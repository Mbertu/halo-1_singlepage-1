<?php
/**
 * Halo1AbstractController - abstract controller class
 */

abstract class Halo1AbstractController {

    /**
     * Array where are stored the instances of any controllers
     * @var array
     */
    private static $instance = array();

    /**
     * View object reference
     * @var Object
     */
    protected $view;

    /**
     * Model object reference
     * @var [type]
     */
    protected $model;

    protected $theme_assets;

    /**
     * Controller contructor, protected to avoid external invock
     * */
    protected function __construct() {}

    /**
     * Singleton pattern main mathod, needed to create a new instance of a child class
     * or return and already created child class
     * */
    public static function getInstance($className, $args) {
        if (!function_exists('get_called_class')) {
            $c = $className;
        }else{
            $c = get_called_class();
        }
        if ( !isset( self::$instance[$c] ) ) {
            self::$instance[$c] = new $c();
            self::$instance[$c]->init($args);
        }
        return self::$instance[$c];
    }

    /**
     * Method to get the desired view
     * @since  2.5.0
     * */
    public function getProperty($name){
        if(property_exists(get_class($this), $name)){
            return $this->$name;
        }
        return null;
    }

    /**
     * Method to get the desired view
     * @since  2.5.0
     * */
    public function setProperty($name, $value){
        if(property_exists(get_class($this), $name)){
            $this->$name = $value;
            return true;
        }
        return false;
    }

    /**
     * Init the controller
     * */
    public abstract function init($args);

    protected function objectToArray($object) {
        if (is_object($object)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $object = get_object_vars($object);
        }

        if (is_array($object)) {
            /*
            * chiamata ricorsiva
            */
            return array_map(array($this, 'objectToArray'), $object);
        }
        else {
            // Return array
            return $object;
        }
    }

    private function cleanArray($array, $to_delete){
        if(is_array($to_delete)){
            foreach($to_delete as $element){
                unset($array[$element]);
            }
        }else{
            unset($array, $to_delete);
        }
        return $array;
    }

    /**
     * Abstract, call the render method on the view object
     */
    public abstract function renderView($only = false);

    /**
     * Abstract, load the css for the current page
     */
    abstract public function enqueueCss();

    /**
     * Abstract, load the js for the current page
     */
    abstract public function enqueueJs();
}