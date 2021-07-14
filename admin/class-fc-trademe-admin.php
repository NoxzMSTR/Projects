<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.forumcube.com/
 * @since      1.0.0
 *
 * @package    Fc_Trademe
 * @subpackage Fc_Trademe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fc_Trademe
 * @subpackage Fc_Trademe/admin
 * @author     ForumCube <ammad@karigar.pk>
 */
class Fc_Trademe_Admin extends Fc_Trademe_API
{
	use Fc_Trademe_Admin_Woo_Sync;
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->trademe = get_option($this->plugin_name)['fc_tab'];;
		$this->admin_init();
		$this->product_admin_init();
		$this->fc_activate_api();
		$this->fc_final_activate_api();
		add_action('init', array($this,'fc_trademe_fetch_product'));
		add_action('init', array($this,'fc_trademe_fetch_category'));
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fc_Trademe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fc_Trademe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/fc-trademe-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fc_Trademe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fc_Trademe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/fc-trademe-admin.js', array('jquery'), $this->version, false);
	}
	private function fc_activate_api()
	{

		if (isset($_REQUEST['fc_trademe_activation'])) {
			$fc_trademe = $this->trademe;

			if (empty($fc_trademe['fc_group']['fc_pre_token'])) {
				$url = 'https://secure.trademe.co.nz/Oauth/RequestToken?scope=' . implode(',', $fc_trademe['fc_scope']);
				$header = array(
					'Authorization' => 'OAuth oauth_consumer_key="' . $fc_trademe['fc_consumer_key'] . '",oauth_signature_method="' . $fc_trademe['fc_signature_method'] . '",oauth_callback="' . $fc_trademe['fc_callback_url'] . '",oauth_signature="' . $fc_trademe['fc_signature'] . '%26"'
				);
				$method = 'POST';
				$post_data = '';

				$data = $this->api($url, $header, $method, $post_data);
				parse_str($data['body'], $output);

				$output['fc_group'] = array(
					'fc_pre_token' => $output['oauth_token'],
					'fc_pre_token_secret' => $output['oauth_token_secret'],
					'fc_usr_link' => 'https://secure.trademe.co.nz/Oauth/Authorize?oauth_token=' . $output['oauth_token']
				);

				$fc_trademe_new['fc_tab'] =  array_merge($fc_trademe, $output);

				update_option($this->plugin_name, $fc_trademe_new);
			}
		}
	}
	private function fc_final_activate_api()
	{

		if (isset($_REQUEST['fc_trademe_final_activation'])) {
			$fc_trademe = $this->trademe;

			if (empty($fc_trademe['fc_group']['fc_final_token'])) {
				$url = 'https://secure.trademe.co.nz/Oauth/AccessToken';

				$header = array(
					'Authorization' => 'OAuth oauth_consumer_key="' . $fc_trademe['fc_consumer_key'] . '",oauth_token="' . $fc_trademe['fc_group']['fc_pre_token'] . '",oauth_signature_method="' . $fc_trademe['fc_signature_method'] . '",oauth_callback="' . $fc_trademe['fc_callback_url'] . '",oauth_verifier="' . $fc_trademe['fc_verifier'] . '",oauth_signature="' . $fc_trademe['fc_signature'] . '%26' . $fc_trademe['fc_group']['fc_pre_token_secret'] . '"'
				);
				$method = 'POST';
				$post_data = '';

				$data = $this->api($url, $header, $method, $post_data);
				parse_str($data['body'], $output);

				$output['fc_group'] = array_merge($fc_trademe['fc_group'], array(
					'fc_final_token' => $output['oauth_token'],
					'fc_final_token_secret' => $output['oauth_token_secret']

				));

				$fc_trademe_new['fc_tab'] =  array_merge($fc_trademe, $output);
				print_r($fc_trademe_new);
				update_option($this->plugin_name, $fc_trademe_new);
			}
		}
	}
	public function fc_trademe_fetch_product()
	{

		if (isset($_REQUEST['fc_trademe_sync_product'])) {
			$fc_trademe = $this->trademe;


			$url = 'https://api.trademe.co.nz/v1/MyTradeMe/SellingItems/All.json';

			$header = array(
				'Authorization' => 'OAuth oauth_consumer_key="' . $fc_trademe['fc_consumer_key'] . '",oauth_token="' . $fc_trademe['fc_group']['fc_final_token'] . '",oauth_signature_method="' . $fc_trademe['fc_signature_method'] . '",oauth_callback="' . $fc_trademe['fc_callback_url'] . '",oauth_signature="' . $fc_trademe['fc_signature'] . '%26' . $fc_trademe['fc_group']['fc_final_token_secret'] . '"'
			);
			$method = 'GET';
			$post_data = '';

			$data = $this->api($url, $header, $method, $post_data);
			
			$data = json_decode($data['body'],true);


			
			foreach ($data['List'] as $productData) {

				$url = 'https://api.trademe.co.nz/v1/Listings/'.$productData['ListingId'].'.json';
				$data = $this->api($url, $header, $method, $post_data);
				$data = json_decode($data['body'],true);
				$args = array(
					'meta_key' => '_ListingId',
					'meta_value' => $productData['ListingId'],
					'post_type' => 'product'
				);
			
				$query = new WP_Query($args);
				
				if ($query->have_posts()) {
					
					while ($query->have_posts()) {

						$query->the_post();

						$post_id = get_the_ID();
					}
				}
				
				
				if(!empty($post_id) ){
					$this->add_update_wooProduct($data, $post_id);
				}else{
                 $this->add_update_wooProduct($data, $post_id);
				}
			
			return;
			}
			
		}
	}
	public function fc_trademe_fetch_category()
	{

		if (isset($_REQUEST['fc_trademe_sync_category'])) {
			$fc_trademe = $this->trademe;


			$url = 'https://api.trademe.co.nz/v1/Categories.json';

			$header = '';
			$method = 'GET';
			$post_data = '';

			$data = $this->api($url, $header, $method, $post_data);
			
			$data = json_decode($data['body'],true);

			
			$this->sync('sync_tm_category',$data['Subcategories']);
		
			
		}
	}
	/**
	 * Method to create admin options
	 *
	 * @return void
	 */
	private function admin_init()
	{
		//$this->api();
		// Create options
		CSF::createOptions(
			$this->plugin_name,
			array(
				'menu_title'         => __('FC Trademe Settings', $this->plugin_name),
				'menu_slug'          => $this->plugin_name,
				'framework_title'    => __('Settings', $this->plugin_name),
				'menu_position'      => 15,
				'show_search'        => false,
				'show_search'        => false,
				'show_reset_all'     => false,
				'show_reset_section' => false,
				'ajax_save'          => false,
				'show_footer'          => false,
			)
		);

		// Create a section
		CSF::createSection(
			$this->plugin_name,
			array(
				'title'  => __('FC Settings', $this->plugin_name),
				'fields' => array(
					array(
						'id'            => 'fc_tab',
						'type'          => 'tabbed',
						'title'         => '',
						'tabs'          => array(
							array(
								'title'     => 'FAQ',

								'fields'    => array(
									array(
										'id'     => 'fc_faqs',
										'type'   => 'repeater',
										'title'  => 'Enter Answers',
										'fields' => array(
									  
										  array(
											'id'    => 'fc_faq',
											'type'  => 'text',
											'title' => 'Enter Answers for Questions'
										  ),
										  array(
											'id'      => 'fc_faq_auto',
											'type'    => 'checkbox',
											'title'   => 'Auto Answer the Question',
											
											'default' => false // or false
										  )
										),
									  ),
								)
							),
							array(
								'title'     => 'Schedules',

								'fields'    => array(

								)
							),
							array(
								'title'     => 'API Settings',

								'fields'    => array(
									array(
										'id'    => 'fc_callback_url',
										'type'  => 'text',
										'title' => 'Callback Url',
									),
									array(
										'id'    => 'fc_consumer_key',
										'type'  => 'text',
										'title' => 'Consumer Key',
									),
									array(
										'id'    => 'fc_signature',
										'type'  => 'text',
										'title' => 'Consumer  secret',
									),
									array(
										'id'    => 'fc_signature_method',
										'type'  => 'text',
										'title' => 'Signature Method',
										'default' => 'PLAINTEXT'
									),

									array(
										'id'         => 'fc_scope',
										'type'       => 'checkbox',
										'title'      => 'Select Premissions',
										'options'    => array(
											'MyTradeMeRead' => 'MyTradeMeRead',
											'MyTradeMeWrite' => 'MyTradeMeWrite',
											'BiddingAndBuying' => 'BiddingAndBuying',
										),
										'default'    => array('option-1', 'option-3')
									),
									array(
										'id'    => 'fc_verifier',
										'type'  => 'text',
										'title' => 'User Verifier',
										'after' => '<br>Please after activate press Allow User btn to get verifier.'
									),
									array(
										'type'     => 'callback',
										'function' => 'fc_activate',
									),
									array(
										'id'     => 'fc_group',
										'type'   => 'fieldset',
										'title'  => '',
										'class'  => 'fc_group',

										'attributes'  => array(),
										'fields' => array(
											array(
												'id'    => 'fc_pre_token',
												'type'  => 'text',
												'attributes'  => array(
													'hidden'    => true

												),

											),

											array(
												'id'    => 'fc_pre_token_secret',
												'type'  => 'text',
												'attributes'  => array(
													'hidden'    => true

												),

											),
											array(
												'id'    => 'fc_usr_link',
												'type'  => 'text',
												'attributes'  => array(
													'hidden'    => true

												),

											),
											array(
												'id'    => 'fc_final_token',
												'type'  => 'text',
												'attributes'  => array(

													'hidden'    => true
												),

											),
											array(
												'id'    => 'fc_final_token_secret',
												'type'  => 'text',
												'attributes'  => array(

													'hidden'    => true
												),

											),
										),
									),


								)
							),

						)
					),

				),
			)
		);
		function fc_activate()
		{
			$fc_trademe = get_option('fc-trademe')['fc_tab'];

			if (!empty($fc_trademe['fc_verifier'])) {
				echo '<div class="csf-field csf-field-text">
				<div class="csf-title">
				<h4>Your Trademe API is Activated</h4></div>
				<div class="csf-fieldset">';
				if (!empty($fc_trademe['fc_group']['fc_final_token'])) {
					echo '<a href="' . admin_url('admin.php?page=fc-trademe&fc_trademe_disable_activation=true') . '" style="float: right;margin-left:4px"  class="button button-primary"> Disable Activation</a>';

					echo '<a href="' . admin_url('admin.php?page=fc-trademe&fc_trademe_sync_product=true') . '" style="float: right;margin-left:4px"   class="button button-primary">Product Sync</a>';
					echo '<a href="' . admin_url('admin.php?page=fc-trademe&fc_trademe_sync_category=true') . '" style="float: right;margin-left:4px"   class="button button-primary">Category Sync</a>';
				}


				echo '<a href="' . admin_url('admin.php?page=fc-trademe&fc_trademe_final_activation=true') . '" style="float: right;margin-left:4px"  class="button button-primary"> Final Activation</a>';

				echo '</div>
				
				<div class="clear"></div>
				
				</div>';
			} elseif (!empty($fc_trademe['fc_group']['fc_usr_link'])) {
				echo '<a href="' . $fc_trademe['fc_group']['fc_usr_link'] . '" style="float: right;margin-left:4px" target="_blank"  class="button button-primary"> Allow  User </a>';
			} elseif (!empty($fc_trademe['fc_consumer_key'])) {
				echo '<a href="' . admin_url('admin.php?page=fc-trademe&fc_trademe_activation=true') . '" style="float: right;margin-left:4px" class="button button-primary"> Activate </a>';
			}
		}
	}
	private function product_admin_init()
    {
        function fc_link() {
           $link = get_post_meta($_REQUEST['post'],'fc-bc-int-options-shop-order-page')[0];
          
            echo '<a href="'.$link['fc-bookcloudLINK'].'" target="_blank" class="button-primary">Link</a> ';

          }
  
      CSF::createMetabox($this->plugin_name.'detail-product-page', array(
        'title'     => 'FC Trademe Listing Details',
        'post_type' => 'product',
      ));
      CSF::createSection($this->plugin_name.'detail-product-page', array(
       
        'fields' => array(
  
          //
          // A text field
          array(
            'id'    => 'fc_list_condition',
            'type'  => 'select',
            'title' => 'Condition',
            'options'     => array(
				'New'  => 'New',
				'Used'  => 'Used',
				
			  ),

          ),
          
         
  
  
        )
      ));
	  CSF::createMetabox($this->plugin_name.'price-product-page', array(
        'title'     => 'FC Trademe Listing Pricing & Duration',
        'post_type' => 'product',
      ));
      CSF::createSection($this->plugin_name.'price-product-page', array(
       
        'fields' => array(
  
          //
          // A text field
          array(
            'id'    => 'fc_list_type',
            'type'  => 'select',
            'title' => 'Listing Type',
            'options'     => array(
				'Reserve Listing'  => 'Reserve Listing',
				'Buy Now Only'  => 'Buy Now Only',
				
			  ),

          ),
		  array(
            'id'    => 'fc-condition',
            'type'  => 'select',
            'title' => 'Listing Duration',
            'options'     => array(
				'Default'  => 'Default',
				'2 Days'  => '2 Days',
				'3 Days'  => '3 Days',
				'4 Days'  => '4 Days',
				'5 Days'  => '5 Days',
				'6 Days'  => '6 Days',
				'7 Days'  => '7 Days',
				'10 Days'  => '10 Days',
				'14 Days'  => '14 Days',
				
				
				
			  ),

          ),
          array(
            'id'    => 'fc_list_offer',
            'type'  => 'text',
            'title' => 'Listing Offer Price',
            

          ),
         
  
  
        )
      ));
	  CSF::createMetabox($this->plugin_name.'shipping-product-page', array(
        'title'     => 'FC Trademe Listing Shipping',
        'post_type' => 'product',
      ));
      CSF::createSection($this->plugin_name.'shipping-product-page', array(
       
        'fields' => array(
  
          //
          // A text field
          array(
            'id'    => 'fc_list_freight_rate',
            'type'  => 'text',
            'title' => 'Listing Freight Rate',
            

          ),
		  array(
            'id'    => 'fc_list_pick-ups',
            'type'  => 'select',
            'title' => 'Listing Pick-ups',
            'options'     => array(
				'Default'  => 'Default',
				'Buyer Can Pick-up' ,
				'Buyer Must Pick-up'  ,
				'No Pick-up'  ,
				
				
				
			  ),

          ),
         
         
  
  
        )
      ));
    }
}
