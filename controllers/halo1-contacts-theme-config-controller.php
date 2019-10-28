<?php
/**
 * Halo1ContactsThemeConfigController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1ContactsThemeConfigController extends Halo1AbstractThemeConfigController {

    private $vat_regex = '/[a-z0-9]$/';
    private $phone_regex = '/[+[0-9]{1,4}]{0,1}[0-9 ]$/';


    public function addMenuPage(){
        add_theme_page(__('Contacts','Halo1'),
                        __('Halo1 Contacts','Halo1'),
                        'manage_options',
                        'halo1_'.$this->getProperty('model')->getProperty('page_name').'_config',
                        array( $this, 'renderView' ));
    }

    public function setupSettingSections(){
        $setting_name = $this->registerSetting();

        $sections = array();
        $sections[] = array('name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section', 'label' => __('Contacts configuration for the template', 'Halo1'));

        $this->addSettingsSection($sections);

        $fields = array();
        $fields[] = array('id' => 'company_name', 'label' => __('Company name', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'mobile_phone', 'label' => __('Mobile phone number', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'phone', 'label' => __('Phone number', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'fax', 'label' => __('Fax number', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'email', 'label' => __('Email address', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'address', 'label' => __('Address', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'country', 'label' => __('Country', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'city', 'label' => __('City', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'vat_number', 'label' => __('VAT number', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'maps_key', 'label' => __('Maps Auth Key', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'place_id', 'label' => __('Maps Place ID', 'Halo1'), 'callback' => array($this, 'inputContact'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');


        $this->addSettingsField($fields);
    }

    public function validateInput($args){
        $errors = array();

        foreach($args as $field => &$arg){
            if(empty($arg)){
                continue;
            }

            switch($field){
                case 'phone':
                case 'mobile_phone':
                case 'fax':
                case 'company_name':
                case 'city':
                case 'country':
                case 'address':
                case 'vat_number':
                case 'place_id':
                case 'maps_key':
                    $arg = sanitize_text_field($arg);
                    $arg = esc_html($arg);
                    break;
                case 'email':
                    $arg = sanitize_email($arg);
                    $arg = esc_html($arg);
                    break;
            }
        }

        foreach($errors as $error){
            add_settings_error(
                'halo1_contacts_config_report',
                esc_attr( 'settings_updated' ),
                $error,
                'error'
            );
        }

        if(empty($errors)){
            $this->getProperty('model')->import($args);
        }

        return $this->getProperty('model')->toArray();
    }

    public function inputContact($id){
        $current = $this->getProperty('model')->getProperty($id);
        $args = array(
            'id' => $id,
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'value' => $current
        );
        $this->getProperty('view')->renderInput($args);
        return;
    }

    public function enqueueCss(){

    }

    public function enqueueJs(){
        
    }

    public function renderView($only = false) {
        $args = array(
            'title'                     => 'Halo1 Contacts Configuration',
            'form_id'                   => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_form',
            'fields'                    => $this->getProperty('model')->getProperty('option_name'),
            'sections'                  => $this->getProperty('model')->getProperty('option_name'),
            'permission_error_message'  => __( 'You do not have sufficient permissions to access this page.', 'Halo1' )
        );

        $this->getProperty('view')->render($args);
        return;
    }
}
