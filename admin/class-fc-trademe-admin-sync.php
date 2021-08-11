<?php

trait Fc_Trademe_Admin_Sync 
{

	private function fc_activate_api()
	{

		if (isset($_REQUEST['fc_trademe_activation'])) {
			$fc_trademe = $this->trademe;

			if (empty($fc_trademe['fc_group']['fc_pre_token'])) {
				$url = 'https://secure.trademe.co.nz/Oauth/RequestToken?scope=' . implode(',', $fc_trademe['fc_scope']);
				
				$header = array(
					'Authorization' => 'OAuth oauth_consumer_key="' . $fc_trademe['fc_consumer_key'] . '",oauth_signature_method="' . $fc_trademe['fc_signature_method'] . '",oauth_callback="' .$callback. '",oauth_signature="' . $fc_trademe['fc_signature'] . '%26"'
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
				print_r($fc_trademe_new);
			
				update_option($this->plugin_name, $fc_trademe_new);
				header('location:'.$output['fc_group']['fc_usr_link']);
				die;
			}
		}
	}
	private function fc_callback_api(){
		if (isset($_REQUEST['callback'])) {
			$fc_trademe = $this->trademe;
			
			$output = array(
				'fc_verifier' => $_REQUEST['oauth_verifier'],
				
			);

			$fc_trademe_new['fc_tab'] =  array_merge($fc_trademe, $output);
			print_r($fc_trademe_new);

			
			update_option($this->plugin_name, $fc_trademe_new);
			sleep(2);
			header('location:'.admin_url().'?page=fc-trademe&fc_trademe_final_activation=true');
			
			
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
				
				update_option($this->plugin_name, $fc_trademe_new);
			}
		}
	}
	public function fc_trademe_fetch_product()
	{

		if (isset($_REQUEST['fc_trademe_sync_product'])) {
			


			$url = 'https://api.trademe.co.nz/v1/MyTradeMe/SellingItems/All.json';

			$header = $this->header;
			$method = 'GET';
			$post_data = '';
			if(empty($_REQUEST['listID'])){
			

			$data = $this->api($url, $header, $method, $post_data);
			
			$data = json_decode($data['body'],true);

		
			
			foreach ($data['List'] as $productData) {
				$productData['ListingId'] = '3169668060';
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
			
			}else{
				$productData['ListingId'] = $_REQUEST['listID'];
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
	public function fc_trademe_fetch_unanswered_questions()
	{

		if (isset($_REQUEST['fc_trademe_unanswered_questions'])) {
			$fc_trademe = $this->trademe;


			$url = 'https://api.trademe.co.nz/v1/Listings/questions/unansweredquestions.json';

			$header = $this->header;
			$method = 'GET';
			$post_data = '';

			$data = $this->api($url, $header, $method, $post_data);
			
			$data = json_decode($data['body'],true);
			
			
			$this->sync('sync_unQ',$data['List']);
		
			
		}
	}
}
