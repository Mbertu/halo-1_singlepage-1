<?php
/**
 * La classe Factory che si coouperà di istanziare il giusto
 * controller per la pagina che è stata richiesta
 */
class Halo1Factory implements IHalo1Factory {

    private static $instance;

    private $controllers_path;
    private $models_path;
    private $views_path;

    private $abstract_subfix;

    /**
     * Array of valid agrs for controller categories
     * @since  2.5.0
     * */
     private $controller_categories = array('theme-config', 'metabox', 'frontend', 'theme');

     /**
      * Array of valid agrs for model categories
      * @since  2.5.0
      * */
     private $model_categories = array('theme-config', 'metabox', 'frontend');

     /**
      * Array of valid agrs for view categories
      * @since  2.5.0
      * */
     private $view_categories = array('theme-config', 'metabox', 'frontend');

    /**
     * The class constructor
     * @since  1.0.0
     * */
    public function __construct() {}

    /**
     * Method to get an instance of this class
     * @since  1.0.0
     * */
    public static function getInstance($args){
        if (!isset(self::$instance)){
            self::$instance = new self;
            self::$instance->init($args);
        }
        return self::$instance;
    }

    /**
     * Method to init the factory
     * @since  1.0.0
     * */
    public function init($args){

        $this->setProperty('controllers_path', $args['controllers_path']);
        $this->setProperty('models_path', $args['models_path']);
        $this->setProperty('views_path', $args['views_path']);

        $this->setProperty('abstract_subfix', 'abstracts/');
        return;
    }

    /**
     * Method to get an instance of the desired controller
     * @since  2.0.0
     * */
    public function createController($category, $page, $args = null){
        if(!in_array($category, $this->controller_categories)){
            return new WP_Error( 'wrong_controller_name', __( "Wrong controller category.", 'Halo1' ).' '.$category.'.');
        }

        $class_name = $this->generateClassName($page, $category, 'controller', $category);
        $file_name = $this->generateFilename($page, $category, 'controller');

        if($category == "theme"){
            if(is_null($args))
                $args = array();
            $args['factory-instance'] = $this;
        }

        if(!class_exists('Halo1AbstractController')){
            require_once($this->controllers_path . $this->abstract_subfix . "halo1-abstract-controller.php");
        }

        if($category == "theme-config"){
            if(!class_exists('Halo1AbstractThemeConfigController'))
                require_once($this->controllers_path . $this->abstract_subfix . "halo1-abstract-theme-config-controller.php");
        }

        if($category == "metabox"){
            if(!class_exists('Halo1AbstractMetaboxController'))
                require_once($this->controllers_path . $this->abstract_subfix . "halo1-abstract-metabox-controller.php");
        }

        if($category == "widget"){
            if(!class_exists('Halo1AbstractWidgetController'))
                require_once($this->controllers_path . $this->abstract_subfix . "halo1-abstracts-widget-controller.php");
        }

        if($category == "frontend"){
            if(!class_exists('Halo1WalkerMainMenu'))
                require_once('halo1-walker-main-menu.php');
            if(!class_exists('Halo1WalkerPrivacyMenu'))
                require_once('halo1-walker-privacy-menu.php');
            if(!class_exists('Halo1AbstractFrontendController'))
                require_once($this->controllers_path . "abstracts/halo1-abstract-frontend-controller.php");
        }

        if(!class_exists($class_name))
            require_once($this->controllers_path . $file_name);
        return $class_name::getInstance($class_name, $args);
    }

    /**
     * Method to get the desired model
     * @since  2.0.0
     * */
    public function createModel($category, $page, $args = null){
        if(!in_array($category, $this->model_categories)){
            return new WP_Error( 'wrong_model_name', __( 'Wrong model name:', 'Halo1' ).' '.$category.'.');
        }

        $class_name = $this->generateClassName($page, $category, 'model');
        $file_name = $this->generateFilename($page, $category, 'model');

        if(!class_exists('Halo1AbstractModel')){
            require_once($this->models_path . $this->abstract_subfix . "halo1-abstract-model.php");
        }

        if($category == "theme-config"){
            if(!class_exists('Halo1AbstractThemeConfigModel'))
                require_once($this->models_path . $this->abstract_subfix . "halo1-abstract-theme-config-model.php");
        }

        if($category == "metabox"){
            if(!class_exists('Halo1AbstractMetaboxModel'))
                require_once($this->models_path . $this->abstract_subfix . "halo1-abstract-metabox-model.php");
        }

        if($category == "frontend"){
            if(!class_exists('Halo1AbstractFrontendModel'))
                require_once($this->models_path . "abstracts/halo1-abstract-frontend-model.php");
        }

        if(!class_exists($class_name))
            require_once($this->models_path . $file_name);
        return $class_name::getInstance($class_name, $args);
    }

    /**
     * Method to get the desired view
     * @since  2.0.0
     * */
    public function createView($category, $page, $args = null){
        if(!in_array($category, $this->view_categories)){
            return new WP_Error( 'wrong_view_name', __( 'Wrong view name:', 'Halo1' ).' '.$category.'.');
        }

        $class_name = $this->generateClassName($page, $category, 'view');
        $file_name = $this->generateFilename($page, $category, 'view');

        if(!class_exists('Halo1AbstractView')){
            require_once($this->views_path . $this->abstract_subfix . "halo1-abstract-view.php");
        }

        if($category == "theme-config"){
            if(!class_exists('Halo1AbstractThemeConfigView'))
                require_once($this->views_path . $this->abstract_subfix . "halo1-abstract-theme-config-view.php");
        }

        if($category == "metabox"){
            if(!class_exists('Halo1AbstractMetaboxView'))
                require_once($this->views_path . $this->abstract_subfix . "halo1-abstract-metabox-view.php");
        }

        if($category == "frontend"){
            if(!class_exists('Halo1AbstractFrontendView'))
                require_once($this->views_path . $this->abstract_subfix. "halo1-abstract-frontend-view.php");
        }

        if(!class_exists($class_name))
            require_once($this->views_path . $file_name);
        return $class_name::getInstance($class_name, $args);
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
     * Generate the class name
     * @since  2.5.0
     */
    private function generateClassName($page, $category, $type){
        $className = $this->dashesToCamelCase($this->generateName($page, $category, $type));

        return $className;
    }

    /**
     * Generate the filename for the controller
     * @since  2.5.0
     */
    private function generateFilename($page, $category, $type){
        $fileName = $this->generateName($page, $category, $type).'.php';
        return $fileName;
    }

    private function generateName($page, $category, $type){
        $name = 'halo1-'. $page;

        if($category == 'theme-config'){
            $name .= '-theme-config';
        }

        $name .= '-'.$type;

        return $name;
    }

    private function dashesToCamelCase($string, $capitalizeFirstCharacter = true){

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
