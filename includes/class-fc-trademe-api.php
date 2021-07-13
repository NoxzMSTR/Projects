<?php

/**
 * Fire during plugin API
 *
 * @link       https://www.forumcube.com/
 * @since      1.0.0
 *
 * @package    Fc_Trademe
 * @subpackage Fc_Trademe/includes
 */

/**
 * Fire during plugin API
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Fc_Trademe
 * @subpackage Fc_Trademe/includes
 * @author     ForumCube <ammad@karigar.pk>
 */
class Fc_Trademe_API  {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function api($url,$header,$method,$post_data) {
		$data = wp_remote_post($url, array(
			'headers'     => $header,
			'body'        => $post_data,
			'method'      => $method,
			'data_format' => 'body',
		));
		return $data;
	}

}
