<?php
/**
 * Halo1SocialsThemeConfigController
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SocialsThemeConfigController extends Halo1AbstractThemeConfigController {

    public function addMenuPage(){
        add_theme_page(__('Socials','Halo1'),
                        __('Halo1 Socials','Halo1'),
                        'manage_options',
                        'halo1_'.$this->getProperty('model')->getProperty('page_name').'_config',
                        array( $this, 'renderView' ));
    }

    public function setupSettingSections(){
        $setting_name = $this->registerSetting();

        $sections = array();
        $sections[] = array('name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section', 'label' => __('Social Network Urls configuration for the template', 'Halo1'));

        $this->addSettingsSection($sections);

        $fields = array();
        $fields[] = array('id' => 'facebook_url', 'label' => __('Facebook page URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'twitter_url', 'label' => __('Twitter profile URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'google_plus_url', 'label' => __('G+ page URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'pinterest_url', 'label' => __('Pinterest profile URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'instagram_url', 'label' => __('Instagram profile URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'linkedin_url', 'label' => __('LinkedIn profile URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        $fields[] = array('id' => 'youtube_url', 'label' => __('Youtube channel URL', 'Halo1'), 'callback' => array($this, 'inputSocialUrl'), 'section_name' => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_section');
        
        $this->addSettingsField($fields);
    }

    public function validateInput($args){
        $errors = array();

        foreach($args as $field => &$arg){
            if(empty($arg)){
                continue;
            }
            if(!preg_match('/^http(s){0,1}\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/', $arg)){
                $arg = "";
                $errors[] = sprintf(__('Wrong url for %s profile', 'Halo1'),$field);
            }
        }

        foreach($errors as $error){
            add_settings_error(
                'halo1_socials_config_report',
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

    public function inputSocialUrl($id){
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
            'title'                     => 'Halo1 Social Links Configuration',
            'form_id'                   => 'halo1_'.$this->getProperty('model')->getProperty('page_name').'_form',
            'fields'                    => $this->getProperty('model')->getProperty('option_name'),
            'sections'                  => $this->getProperty('model')->getProperty('option_name'),
            'permission_error_message'  => __( 'You do not have sufficient permissions to access this page.', 'Halo1' )
        );

        $this->getProperty('view')->render($args);
        return;
    }
}
