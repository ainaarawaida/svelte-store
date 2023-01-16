<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mypluginwp
 * @since      1.0.0
 *
 * @package    Mypluginwp
 * @subpackage Mypluginwp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mypluginwp
 * @subpackage Mypluginwp/public
 * @author     mypluginwp <mypluginwp@mypluginwp.mypluginwp>
 */
class Mypluginwp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mypluginwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mypluginwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mypluginwp-public.css', array(), $this->version, 'all' );
		// Print all loaded Scripts
		global $wp_scripts;
		foreach( $wp_scripts->queue as $script ) :
			
			$exclude = array("admin-bar") ;
			if (in_array($script, $exclude))
				continue;
				// deb($script);
		wp_dequeue_script( $script );
		endforeach;

		// Print all loaded Styles (CSS)
		global $wp_styles;
		foreach( $wp_styles->queue as $style ) :
			$exclude = array("admin-bar","wp-block-library","global-styles","wp-webfonts") ;
			if (in_array($style, $exclude))
				continue;
			// deb($style);
			wp_dequeue_style( $style );
		endforeach;

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mypluginwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mypluginwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mypluginwp-public.js', array( 'jquery' ), $this->version, false );

	}

	public function mypwp_authenticate( $user, $username, $password ){
		return;
		if(isset($_GET['state'])) return;
		if($username == '' || $password == '') return;
		
		if(substr(strtoupper($username),0,5) === 'xxx' || $username == 'admin') return;
				$userparams = array('User' => array(
					'clientId' => 'xxx',
					'grantType' => 'xxx',
					'username' => $username,
					'password' => $password
				)) ;
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://xxx/oauth/token',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => http_build_query($userparams),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded'
				),
				));
				$response = curl_exec($curl);
				
				curl_close($curl);
				
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://xxx/oauth/getUser',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.json_decode($response, TRUE)['accessToken'] 
				),
				));

				$response = curl_exec($curl);
			
				curl_close($curl);

				
				if(isset(json_decode($response, TRUE)['name'])){
					$myidno = json_decode($response, TRUE)['mypwp_no'];
					global $mydb1; 
					$rows = $mydb1->get_results("SELECT * FROM `users` WHERE mypwp_no = '{$myidno}' LIMIT 1");

					$user = get_user_by('login', json_decode($response, TRUE)['mypwp_no']);
					if(!$user){
						$userdata = array( 'user_email' => $rows[0]->email,
                                'user_login' => $rows[0]->mypwp_no,
                                'first_name' => $rows[0]->name
                                );
             			$new_user_id = wp_insert_user( $userdata ); 
						$user = new WP_User ($new_user_id);

					}

					if (!empty($user)){
						update_user_meta($user->ID, "staff_data", $rows) ;
						return $user;
					}else{
						return 0;
					}
				}else{
					// deb("sss");exit();
					return 0;
				}
		

	}


	public function mypwp_template_redirect(){
			global $wp;
			// deb($wp);exit();
			if(is_front_page()){
				include_once dirname( __FILE__ ) . '/partials/index.php';
				exit();
			}else if($wp->query_vars['name'] && $wp->query_vars['name'] === "mylogin"){
				include_once dirname( __FILE__ ) . '/partials/index.php';
				exit();
			}

			// mylogin
			
			
			
			// if($wp->query_vars['post_type'] && $wp->query_vars['post_type'] === "product"){
			// 	include_once dirname( __FILE__ ) . '/partials/sendmessage.php';

			// }
			
		}

}
