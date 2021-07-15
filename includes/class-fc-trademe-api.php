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
	public function add_comment_type($args) {
        $this->comment_types = $args;
        $args['trcomment'] = __('Trademe Comments', 'fc-trademe');
       
        return $args;
    }
	
	function woo_product_tabs( $tabs ) {

		$fc_comment_tab = array(
            'title' => 'Comments',
            'priority' => 2,
            'callback' => array(&$this, 'woo_product_tabs_content')
        );
        $tabs['fc_comment_tab'] = $fc_comment_tab;
       
		return $tabs;
	}
	function woo_product_tabs_content( $tabs ) {

		require get_template_directory() . '/comments.php';
		
	}
}
