<?php
/**
 * Halo1AbstractFrontendModel - Abstract model for the frontend Halo structure
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
abstract class Halo1AbstractFrontendModel extends Halo1AbstractModel{

	protected $site_name;
	protected $site_logo;
	protected $site_description;
	protected $site_charset;
	protected $site_no_image;
	protected $site_header_image;
	protected $site_separator;
	protected $html5shiv_js;
	protected $menu_data;
	protected $footer_socials;
	protected $footer_info;
	protected $footer_disclaimer;
    protected $footer_signature;

	protected $parent_defaults = array(
		'site_name' => '',
		'site_logo' => '',
		'site_description' => null,
		'site_charset' => null,
		'site_no_image' => null,
		'site_header_image' => null,
		'site_disclaimer' => null,
		'site_separator' => null,
		'html5shiv_js' => null,
		'menu_data' => null,
		'footer_socials' => null,
		'footer_info' => null,
		'footer_disclaimer' => null,
		'footer_signature' =>null
	);

    /**
     * Method to init the model with input params or default values
     * @since <%= plugin_version_number %>
     */
    protected function init($args){
    	$this->defaults = $this->arrayMerge($this->defaults, $this->parent_defaults);
    	$this->import($this->defaults);
    }
}
