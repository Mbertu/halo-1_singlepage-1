<?php
/**
 * Halo1ContactsThemeConfigModel
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1ContactsThemeConfigModel extends Halo1AbstractThemeConfigModel {

    protected $company_name;
    protected $mobile_phone;
    protected $phone;
    protected $fax;
    protected $email;
    protected $address;
    protected $country;
    protected $city;
    protected $vat_number;
    protected $place_id;
    protected $maps_key;
    protected $theme_folder;

    /**
     * Default options
     * @since <%= plugin_version_number %>
     */
    protected $defaults = array(
        'company_name' => '',
        'mobile_phone' => null,
        'phone' => null,
        'fax' => null,
        'email' => null,
        'address' => null,
        'country' => null,
        'city' => null,
        'vat_number' => null,
        'place_id' => null,
        'maps_key' => null,
        'theme_folder' => null
    );
}
