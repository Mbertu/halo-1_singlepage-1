<?php
/**
 * Halo1SocialsThemeConfigModel
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SocialsThemeConfigModel extends Halo1AbstractThemeConfigModel {

    protected $facebook_url;
    protected $twitter_url;
    protected $google_plus_url;
    protected $pinterest_url;
    protected $instagram_url;
    protected $linkedin_url;
    protected $youtube_url;


    protected $defaults = array(
        'facebook_url' => null,
        'twitter_url' => null,
        'google_plus_url' => null,
        'pinterest_url' => null,
        'instagram_url' => null,
        'linkedin_url' => null,
        'youtube_url' => null,
    );


}
