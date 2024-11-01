<?php
/*
* Plugin Name: WP URL Shortener
* Plugin URI: https://blog.alisaleem252.com/2024/10/wp-url-shorten-plugin-documentation-for.html
* Description: Shortens URLS of your blog posts via eeb.me zpit.us cvrd.us eaby.us service for twitter and can be used to hide referer
* Version: 10.0
* Author: alisaleem252
* Author URI: https://alisaleem252.com
* Text Domain: eebme
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



define('eebme_API_URL', 'https://eeb.me/api/url/add');
//// END MAM updated ////////////
define('eebme_plugin_path', plugin_dir_path(__FILE__) );
define('eebme_plugin_url', plugin_dir_url(__FILE__) );

require_once(eebme_plugin_path.'inc/class.eebme_Short_URL.php');
$eebme = new eebme_Short_URL;
$eebme->init();

add_filter( 'plugin_row_meta', 'eebme_plugin_row_meta', 10, 2 );
function eebme_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'eebme_shorturl.php' ) !== false ) {
		$new_links = array('<a href="https://webostock.com" target="_blank">Premium Plugins</a>');
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}

/* ACTIVATION */
register_activation_hook(__FILE__, array(new eebme_Short_URL,'eebme_plugin_activate') );






