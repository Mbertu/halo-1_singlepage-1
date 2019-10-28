<?php
/**
 * Halo1AbstractThemeConfigController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractThemeConfigController extends Halo1AbstractController{

    /*
     * Metodo per inizializzare l'oggetto appena instanziato
     *
     * */
    public function init($args) {
        $this->setProperty('theme_assets', get_template_directory_uri().'/assets/');
        $this->setProperty('model', isset($args['model']) ? $args['model'] : null);
        $this->setProperty('view', isset($args['view']) ? $args['view'] : null);
    }

    protected function registerSetting(){
        register_setting( $this->getProperty('model')->getProperty('option_name'), $this->getProperty('model')->getProperty('option_name'), array($this, 'validateInput'));
        return $this->getProperty('model')->getProperty('option_name');
    }

    protected function addSettingsSection($sections) {
        foreach($sections as $section){
            add_settings_section(
                $section['name'],
                $section['label'],
                null,
                $this->getProperty('model')->getProperty('option_name')
            );
        }
    }

    protected function addSettingsField($fields){
        foreach($fields as $field){
            add_settings_field(
                $field['id'],
                $field['label'],
                $field['callback'],
                $this->getProperty('model')->getProperty('option_name'),
                $field['section_name'],
                $field['id']
            );
        }
    }

    abstract public function addMenuPage();

    abstract public function setupSettingSections();

    abstract protected function validateInput($args);
}
