<?php
/**
 * Halo1SubtitleMetaboxModel - Subtitle field metabox model
 *
 * @package   <%= appname %>
 * @author    <%= author %> <<%= author_email %>>
 * @license   <%= license %>
 * @link      <%= author_website %>
 * @copyright <%= currentYear %> <%= author %>
 */
class Halo1SubtitleMetaboxModel extends Halo1AbstractMetaboxModel {
	protected $subtitle;

    protected $defaults = array(
    	'subtitle' => ''
    );
}