<?php
/**
 * Halo1AbstractModel - Abstract model for the Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractModel{
    /**
     * Plugin version
     * @since <%= plugin_version_number %>
     */
    protected $version;

    /**
     * Option name for the saved data of this model
     * @since <%= plugin_version_number %>
     */
    protected $option_name;

    /**
     * Current page name
     * @since <%= plugin_version_number %>
     */
    protected $page_name;

    /**
     * Model constructor
     * @since <%= plugin_version_number %>
     * */
    protected function __construct() {}

    /**
     * Method to get an instance for the child model
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
     * Abstract, init the model with input data
     * @since <%= plugin_version_number %>
     * */
    protected abstract function init($args);

    /**
     * Import the options from array
     * @since <%= plugin_version_number %>
     */
    public function import($args){
        if(isset($args) && !empty($args)){
            $filtered = $this->arrayMerge($args, $this->toArray());
        }else{
            $filtered = $this->toArray();
        }

        foreach ($filtered as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    /**
     * Method to get the desired view
     * @since  2.0.0
     * */
    public function getProperty($name){
        if(property_exists(get_class($this), $name)){
            return $this->$name;
        }
        return null;
    }

    /**
     * Method to get the desired view
     * @since  2.0.0
     * */
    public function setProperty($name, $value){
        if(property_exists(get_class($this), $name)){
            $this->$name = $value;
            return true;
        }
        return false;
    }

    /**
     * Method to get if value is the default one
     * @return boolean return if the current value is the default one
     * @since 2.6.0
     */
    public function isDefault($property, $value = null){
        if(property_exists(get_class($this), $property)){
            if(is_null($value)){
                if($this->defaults[$property] == $this->getProperty($property)){
                    return true;
                }
            }else{
                if($this->defaults[$property] == $value){
                    return true;
                }
            }

        }
        return false;
    }

    /**
     * Method to reset the Property to default
     * @since 2.6.0
     */
    public function resetProperty($property){
        $this->setProperty($property, $this->getProperty('defaults')[$property]);
    }

    /**
     * Export the options as array
     * @since <%= plugin_version_number %>
     */
    public function toArray(){
        $state = array();
        foreach($this->defaults as $key => $value){
            $state[$key] = $this->getProperty($key);
        }
        return $state;
    }

    /**
     * Merge the array 1 with the array 2 giving priority to the contents of the array 1,
     * replacing the null values with the values from the array 2
     * @since <%= plugin_version_number %>
     */
     public function arrayMerge($array1, $array2){
         $new_array = array();
         foreach($array1 as $key => $value){
             if(!empty($value) || is_bool($value) || $value==''){
                 $new_array[$key] = $value;
                 continue;
             }
             if(isset($array2[$key]) && !empty($array2[$key])){
                 $new_array[$key] = $array2[$key];
                 continue;
             }
             $new_array[$key] = null;
         }
         foreach($array2 as $key => $value){
             if(isset($new_array[$key])){
                 continue;
             }
             if(!empty($value) || is_bool($value)){
                 $new_array[$key] = $value;
                 continue;
             }
             $new_array[$key] = null;
         }
         return $new_array;
     }
}
