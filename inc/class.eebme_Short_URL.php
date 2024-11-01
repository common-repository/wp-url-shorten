<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eebme_Short_URL
{
    const META_FIELD_NAME='Shorter link';
	public $api;
	public $format;
	public $errors;
	
	function init(){
	//	if (is_admin()) {
			//add_action('edit_post', array(&$this, 'create'));
			add_action('save_post', array(&$this, 'create'));
			add_action('publish_post', array(&$this, 'create'));
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_filter('pre_get_shortlink',  array(&$this, 'pre_get_shortlink'), 10, 4);
	//	} else {
			add_filter('the_content', array(&$this, 'display'));	
	//	}
		
		add_action('admin_enqueue_scripts',array(&$this,'eebme_admin_scripts'));
		add_action('admin_head',array(&$this,'eebme_head'));
		add_action( 'add_meta_boxes', array(&$this,'eebme_add_meta_box' ));
		add_action('admin_init', array(&$this,'eebme_plugin_redirect'));
		$this->add_shortcode();
		$this->api = get_option('eebmeShortURLeebapikey');
		$this->format = 'json';
		$this->url;
		$this->domain;
		$this->id;


	}
	


	function eebme_plugin_activate() {
		add_option('eebme_plugin_do_activation_redirect', true);
	}
	
	function eebme_plugin_redirect() {
		if (get_option('eebme_plugin_do_activation_redirect', false)) {
			delete_option('eebme_plugin_do_activation_redirect');
			wp_redirect('admin.php?page=eebme_short_link_settings_page2');
		}
	}

	function add_shortcode(){
		add_shortcode('eebme-url', array(&$this,'eebme_shortcode_handler'));
		add_shortcode('short-url', array(&$this,'eebme_shortcode_handler'));
	}    
		
	function eebme_shortcode_handler( $atts, $text = null, $code = "" ) {
		$post_id = get_the_ID();
		
		$url = get_eebme_url( $post_id );
	
		if( !$u )
			return $rurl;
		if( !$text )
			return '<a href="' .$url. '">' .$url. '</a>';
		
		return '<a href="' .$url. '">' .$text. '</a>';
	 }
	 
	 function eebme_show_url($showurl) { /* use with echo statement */
		  $url_create = $this->get_eebme_url( $id );
		
		  $kshort .= '<a href="'.$url_create.'" target="_blank">'.$url_create.'</a>';
		  return $kshort;
	 }

	function eebme_wp_remote_get($post_id){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer $this->api",
			"Content-Type: application/json",
		),
		CURLOPT_POSTFIELDS => json_encode(array (
			'url' => get_permalink($post_id),
			'domain' => $this->domain,
		)),
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_URL => eebme_API_URL,
		));
		$Response = curl_exec($curl);
		curl_close($curl);
		return ($Response);

	}

	/* returns a result from url */
	function eebme_curl_get_url($post_id) {
		  // use Api key input
		$short_id = get_post_meta($post_id,'eebmeShortURL_id',true);
		
		//print_r($request);
		$args = array(
		'timeout'     => 30,
		'httpversion' => '1.1',
		'method' => 'GET',
		'redirection' => 5,
		'blocking' => true,
		'headers' => array(
			"Authorization: Bearer $this->api",
			'Content-Type' => 'application/json'
			),
		'cookies' => array(),
		
		);
		
		$data = wp_remote_get( "https://eeb.me/api/url/$short_id",$args );
		if($data['response']['code'] == 404){
		$data = $this->eebme_wp_remote_get( $post_id );
		$data = json_decode($data);
		$data = $data->details->shorturl;
		}
		else {
		$data = json_decode($data['body']);	
		$data = $data->details->shorturl;
			}		
		
	
		return $data;
	}


	function get_eebme_url($post_id) {
	  // global $var_Apikey;
		
	   $eebmeShortURLDomain = get_option('eebmeShortURLDomain','eeb.me');
	   $eebmeShortURLDomain = 'https://'.$eebmeShortURLDomain;
	   
	   return $this->eebme_curl_get_url($post_id);
	 }



    /**
     * Create short URL based on post URL
     */
    function create($post_id)
    {
        

        // For some reason the post_name changes to /{id}-autosave/ when a post is autosaved
        $post = get_post($post_id);
		
		
		if($post->post_status !== 'publish')
		return false;

		$eebmeShortURLDomain = get_option('eebmeShortURLDomain','eeb.me');
	   	//$eebmeShortURLDomain = 'https://'.$eebmeShortURLDomain;
		$this->domain = $eebmeShortURLDomain;
        
		
        $result = false;


		$result = $this->eebme_wp_remote_get($post_id);
        
        if ($result !== false) {
          //  delete_post_meta($post_id, 'eebmeShortURLnew');
            $result = json_decode($result);
            update_post_meta($post_id, 'eebmeShortURLnew', $result->shorturl, true);
			update_post_meta($post_id, 'eebmeShortURL_id', $result->id, true);
            return true;
        }
    }

    /**
     * Option list (default settings)
     */
    
    function options()
    {
        return array(
           'ApiUrl'         => eebme_API_URL,
		   'eebapikey'		=> '',
           'Display'        => 'Y',
           'TwitterLink'    => 'Y',
		   'Domain'			=> 'eeb.me'
           );
    }
    
    /**
     * Plugin settings
     *
     */
    
    function settings()
    {
        $options = $this->options();
        $opt = array();
	//var_dump(wp_verify_nonce('_wpnonce','eebme_action_saveurl'));die();
        if (!empty($_POST) && wp_verify_nonce($_POST['_wpnonce'],'eebme_action_saveurl')) {
			
            foreach ($options AS $key => $val)
            {
                if (!isset($_POST[$key])) {
                    continue;
                }
                update_option('eebmeShortURLnew' . $key, sanitize_text_field($_POST[$key]));
            }
        }
        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('eebmeShortURLnew' . $key);
        }
        include eebme_plugin_path . 'template/settings.tpl.php';
    }
    
    /**
     *
     */
    
    function admin_menu()
    {
//        add_options_page('WP Short URLs by Ref.li', 'WP URLs Shorten', 10, 'eebme_shorturl-settings', array(&$this, 'settings'));
	add_menu_page('WP URL SHORTEN', 'WP URL SHORTEN', 'administrator','eebme_short_link_settings_page', array(&$this,'eebme_short_link_settings_page'),eebme_plugin_url.'icon.png');
	add_submenu_page( 'eebme_short_link_settings_page', 'WP Short URLs by EEB.ME','Settings' , 'manage_options', 'eebme_short_link_settings_page2', array(&$this, 'settings') ); 

    }
    
    /**
     * Display the short URL
     */
    function display($content)
    { 
			
		if(is_admin())
		return;
		
        global $post;
		

        if ($post->ID <= 0) {
            return $content;
        }

        $options = $this->options();
	

        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('eebmeShortURLnew' . $key);
        }

        $shortUrl = get_post_meta($post->ID, 'eebmeShortURLnew', true);


        if (empty($shortUrl)) {
   //         $shortUrl = $this->get_eebme_url(get_permalink( $post->ID ));
        }
		
		//////// MAM ////////////////$shortUrl = str_replace('eeb.me', $shortUrl);
        $shortUrlEncoded = urlencode("https://$shortUrl");
		
		$domain = $opt['Domain'];



        ob_start();
        include eebme_plugin_path . 'template/public.tpl.php';
        $content .= ob_get_contents();
        ob_end_clean();

        return $content;
    } // function 
	
	
	
	 
	
	
	

    public function pre_get_shortlink($false, $id, $context=null, $allow_slugs=null) /* Thanks to Rob Allen */
    {
        // get the post id
        global $wp_query;
        if ($id == 0) {
            $post_id = $wp_query->get_queried_object_id();
        } else {
            $post = get_post($id);
            $post_id = $post->ID;
        }

        $short_link = get_post_meta($post_id, self::META_FIELD_NAME, true);
        if('' == $short_link) {
            $short_link = $post_id;
        }
		
		$post = get_post($id);
        $pos = strpos($post->post_name, 'autosave');
        if ($pos !== false) {
            return false;
        }
        $pos = strpos($post->post_name, 'revision');

        if ($pos !== false) {
            return false;
        }
		
        $url = $this->get_eebme_url( $id);

        if (!empty($url)) {
            $short_link = $url;
        } else {
            $short_link = home_url($short_link);
        }
        return $short_link;
    }
	
	
	function eebme_admin_scripts(){
		wp_enqueue_script('eebme-table',eebme_plugin_url.'/js/jquery.dataTables.min.js',array('jquery'));
		wp_enqueue_style('eebme-table',eebme_plugin_url.'/css/jquery.dataTables.min.css');
	}
	function eebme_head(){
		echo '<script>
		jQuery(document).ready(function(){
		jQuery("#myTable").DataTable();
		});
		</script>
		';
		
		
	}
	
	function  eebme_short_link_settings_page() {
		?>
		<div class="wrap">
		
		 <div>
		<h2>Statistics</h2>
		<?php
		$posts = get_posts('posts_per_page=5');
		global $wpdb;
		$allurls = $wpdb->get_results( "SELECT * FROM  $wpdb->postmeta WHERE  meta_key = 'eebmeShortURLnew'", OBJECT);
		
		
		echo '<table id="myTable" class="display">';
		echo '<thead>';
		
		echo '<th>Object ID</th>';
		echo '<th>Object Title</th>';
		echo '<th>Short URL</th>';
		echo '<th>Statistics</th>';
		echo '</thead>';
		echo '<tbody>';
		if (!empty($allurls)){
		foreach($allurls as $singleurl){
			$short = $singleurl->meta_value;//get_post_meta($post->ID,'eebmeShortURLnew',true);
			$short = str_replace('ref.li','eeb.me',$short);
			//$clicks = json_decode($clicks);
			//if ($clicks->error != 1){
			echo '<tr>';
		
			echo '<td>'.$singleurl->post_id.'</td>';	
			echo '<td>'.get_the_title($singleurl->post_id).'</td>';	
			echo '<td>'.$short.'</td>';
			echo '<td> <a target="_blank" href="https://'.$short.'+">View Statistics</a> </td>';
		
			echo '</tr>';
		
		
		}
		}
		echo '</tbody>';
		echo '</table>';
		?>
		</div>
		
		</div>
		
		<?php } 
		
		function eebme_add_meta_box() {
		
				 add_meta_box(
				 	'eebme_sectionid',
				 	__( 'Short Link Stats', 'eebme' ),
				 	array($this,'eebme_meta_box_callback'),
				 	'post','side','high'
				 );
			
		}
		function eebme_meta_box_callback( $post ) {
		
			// Add an nonce field so we can check for it later.
			
		
			/*
			 * Use get_post_meta() to retrieve an existing value
			 * from the database and use the value for the form.
			 */
			$short = get_post_meta( $post->ID, 'eebmeShortURLnew', true );
			$url = get_permalink($post->ID);
			

			if($short){
				echo '<h2>';
				echo '<p>'.$short.'</p>';
				echo '</h2> ';
				echo '<a target="_blank" href="'.$short.'+">'. __('More Details').'..</a>';
			}
			else {
				_e( ' No Short Link', 'eebme' );
			}
			
		
		}


}