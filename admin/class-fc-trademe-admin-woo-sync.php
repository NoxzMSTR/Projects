<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/get-slade-642236212/
 * @since      1.0.0
 *
 * @package    Trademe
 * @subpackage Trademe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Trademe
 * @subpackage Trademe/admin
 * @author     AmmadJ <ammad@kariger.pk>
 */
trait Fc_Trademe_Admin_Woo_Sync 
{
    public function __construct() {
      
        $this->trademe = get_option('fc-trademe')['fc_tab'];
		$fc_trademe = $this->trademe;
		$this->header = array(
			'Authorization' => 'OAuth oauth_consumer_key="' . $fc_trademe['fc_consumer_key'] . '",oauth_token="' . $fc_trademe['fc_group']['fc_final_token'] . '",oauth_signature_method="' . $fc_trademe['fc_signature_method'] . '",oauth_callback="' . $fc_trademe['fc_callback_url'] . '",oauth_signature="' . $fc_trademe['fc_signature'] . '%26' . $fc_trademe['fc_group']['fc_final_token_secret'] . '"'
		);
        
     }
    
    public function add_update_wooProduct($productData, $post_id)
    {
         $agent = $_SERVER['HTTP_USER_AGENT'];
         $agent_ip = $_SERVER['REMOTE_HOST'];
        //BookCloud Panel option
        if (empty($post_id)) {
            if (empty($productData['Body'])) {
                $productData['Body'] = 'No data';
            }
            $post = array(
                'post_author' => get_current_user_id(),
                'post_content' => $productData['Body'],
                'post_status' => "publish",
                'post_title' => $productData['Title'],
                'post_parent' => '',
                'post_type' => "product",
            );
            // print_r($post);
            //Create post
            $post_id = wp_insert_post($post);
            if(isset($productData['Questions'])){
            
                foreach($productData['Questions']['List'] as $question){
                    $CommentDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$question['CommentDate']))));
                    $data = array(
                        'comment_post_ID' => $post_id ,
                        'comment_author' => $question['AskingMember']['Nickname'],
                        'comment_author_email' => '',
                        'comment_author_url' => '',
                        'comment_content' => $question['Comment'],
                        'comment_author_IP' => $agent_ip,
                        'comment_agent' => $agent,
                        'comment_type'  => 'trcomment',
                        'comment_date' => date('Y-m-d H:i:s',ceil($CommentDate / 1000)),
                        'comment_date_gmt' => date('Y-m-d H:i:s',ceil($CommentDate / 1000)),
                        'comment_approved' => 1,
                    
                    );
                  
                    $comment_id = wp_insert_comment($data);
                    add_comment_meta($comment_id,'ListingQuestionId',$question['ListingQuestionId']);
                    if(!empty($question['Answer'])){
                        $AnswerDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$question['AnswerDate']))));
                        $data = array(
                            'comment_post_ID' => $post_id ,
                            'comment_author' => $productData['Member']['Nickname'],
                            'comment_author_email' => '',
                            'comment_author_url' => '',
                            'comment_parent' =>  $comment_id,
                            'comment_content' => $question['Answer'],
                            'comment_author_IP' => $agent_ip,
                            'comment_agent' => $agent,
                            'comment_type'  => 'trcomment',
                            'comment_date' => date('Y-m-d H:i:s',ceil($AnswerDate / 1000)),
                            'comment_date_gmt' => date('Y-m-d H:i:s',ceil($AnswerDate / 1000)),
                            'comment_approved' => 1,
                        
                        );
                      
                        $comment_id = wp_insert_comment($data);
                       
                    }
                    echo ' Fetched The Item and id is : ' . $post_id;
                }
             }
          
        } else {
            $post = array(
                'ID' => esc_sql($post_id),
                'post_content' => wp_kses_post($productData['Body']),
                'post_title' => wp_strip_all_tags($productData['Title'])
            );
            $result = wp_update_post($post, true);
            echo ' Fetched The Item and id is : ' . $post_id;
            if(isset($productData['Questions'])){
              
               
                foreach($productData['Questions']['List'] as $question){
                    
                    $comments =  $this->get_custom_comment($post_id,$question['ListingQuestionId'],'comment')[0];
                    
                    
                    if(empty($comments->comment_ID)){
                        $CommentDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$question['CommentDate']))));
                        $data = array(
                            'comment_post_ID' => $post_id ,
                            'comment_author' => $question['AskingMember']['Nickname'],
                            'comment_author_email' => '',
                            'comment_author_url' => '',
                            'comment_content' => $question['Comment'],
                            'comment_author_IP' => $agent_ip,
                            'comment_agent' => $agent,
                            'comment_type'  => '',
                            'comment_date' => date('Y-m-d H:i:s',ceil($CommentDate / 1000)),
                            'comment_date_gmt' => date('Y-m-d H:i:s',ceil($CommentDate / 1000)),
                            'comment_approved' => 1,
                        
                        );
                      
                        $comment_id = wp_insert_comment($data);
                        add_comment_meta($comment_id,'ListingQuestionId',$question['ListingQuestionId']);
                        if(!empty($question['Answer'])){
                            $AnswerDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$question['AnswerDate']))));
                            $data = array(
                                'comment_post_ID' => $post_id ,
                                'comment_author' => $productData['Member']['Nickname'],
                                'comment_author_email' => '',
                                'comment_author_url' => '',
                                'comment_parent' =>  $comment_id,
                                'comment_content' => $question['Answer'],
                                'comment_author_IP' => $agent_ip,
                                'comment_agent' => $agent,
                                'comment_type'  => '',
                                'comment_date' => date('Y-m-d H:i:s',ceil($AnswerDate / 1000)),
                                'comment_date_gmt' => date('Y-m-d H:i:s',ceil($AnswerDate / 1000)),
                                'comment_approved' => 1,
                            
                            );
                          
                            $comment_id = wp_insert_comment($data);
                           
                        }
                    }
                   
                }
             }
           
          
        }
        


        wp_set_object_terms($post_id, $productData['CategoryName'], 'product_cat');

        if($productData['IsNew']==1){
            update_post_meta($post_id, '_condition', 'New');
           // wp_set_object_terms($post_id, 'New', 'product_cat');
        }else{
            update_post_meta($post_id, '_condition', 'Used');
            //wp_set_object_terms($post_id, 'Used', 'product_cat');
        }
        $StartDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$productData['StartDate']))));
        $EndDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$productData['EndDate']))));
			

        

        wp_set_object_terms($post_id, 'simple', 'product_type');
        $tags = explode(',', $productData['subjects']);
        wp_set_object_terms($post_id, $tags, 'product_tag');
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_ListingId', $productData['ListingId']);
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, 'total_sales', '0');
        update_post_meta($post_id, '_downloadable', 'no');
        update_post_meta($post_id, '_virtual', 'no');

        update_post_meta($post_id, '_regular_price', $productData['WasPrice']);
        update_post_meta($post_id, '_sale_price', $productData['BuyNowPrice']);
        update_post_meta($post_id, '_purchase_note', "");
        update_post_meta($post_id, '_featured', "no");
        update_post_meta($post_id, '_weight', "");
        update_post_meta($post_id, '_length', "");
        update_post_meta($post_id, '_width', "");
        update_post_meta($post_id, '_height', "");
        update_post_meta($post_id, '_sku', $productData['SKU']);
        update_post_meta($post_id, '_product_attributes', array());
        update_post_meta($post_id, '_sale_price_dates_from', date('c',ceil($StartDate / 1000)));
        update_post_meta($post_id, '_sale_price_dates_to',date('c',ceil($EndDate / 1000)));
        update_post_meta($post_id, '_price', $productData['BuyNowPrice']);
        update_post_meta($post_id, '_sold_individually', "");
        update_post_meta($post_id, '_manage_stock', "yes");
        update_post_meta($post_id, '_backorders', "no");
        update_post_meta($post_id, '_stock', $productData['Quantity']);
     
        foreach ($productData['Attributes'] as $key => $attr) {
            
            wp_set_object_terms( $post_id, $attr['Value'], $attr['Name'], true );

            $att = Array($attr['Name'] =>Array(
                   'name'=> $attr['DisplayName'],
                   'value'=>$attr['Value'],
                   'is_visible' => '1',
                   'is_taxonomy' => '0'
                 ));
            
            update_post_meta( $post_id, '_product_attributes', $att);

        }
         



        // // file paths will be stored in an array keyed off md5(file path)

        $this->upload_image($productData['Photos'][0]['Value']['FullSize'], $post_id, 'main');
        $inc = 0;
        foreach ($productData['Photos'] as $key => $imgurl) {
            
            if ($key !== 0) {
                $attachmentId[] =  $this->upload_image($imgurl['Value']['FullSize'], $post_id, 'gallery');
            }
        }
        
          update_post_meta($post_id, '_product_image_gallery', implode(", ", $attachmentId));

          if(isset($productData['Sales'])){
            foreach($productData['Sales'] as $order_data){
            $order_id =  get_post_meta( $post_id, '_order_id')[0];
                
            $purc_id =  get_post_meta( $order_id, 'PurchaseId')[0];
            $order_data['PurchaseId'];
                if($purc_id == $order_data['PurchaseId']){

                }else{
                    $order =  $this->add_order($order_data,$post_id);
                    $order = json_decode($order,true);
                    update_post_meta( $post_id, '_order_id', $order['id']);
                }
          
            
            }
          
        }
        
    }
    /**
     * Method to Upload Image of BC Products To WOO
     *
     * @return void
     */
    function upload_image($url, $post_id, $type)
    {
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
        $image = "";
        if ($url != "") {

            $file = array();
            $file['name'] = basename($url);
            $title = preg_replace( '/\.[^.]+$/', '', basename( $file['name'] ) );
            if (!post_exists($title)){
            $file['tmp_name'] = download_url($url);

            if (is_wp_error($file['tmp_name'])) {
                @unlink($file['tmp_name']);
                var_dump($file['tmp_name']->get_error_messages());
            } else {
                $attachmentId = media_handle_sideload($file, $post_id);
                if ($post_id) {
                    if ($type == 'main') {
                        update_post_meta($post_id, '_thumbnail_id', $attachmentId);
                    }
                }
                if (is_wp_error($attachmentId)) {
                    @unlink($file['tmp_name']);
                    var_dump($attachmentId->get_error_messages());
                } else {
                    $image = wp_get_attachment_url($attachmentId);
                }
            }
        }else{
            $page = get_page_by_title($title, OBJECT, 'attachment');
            $attachmentId = $page->ID;
            if ($type == 'main') {
                update_post_meta($post_id, '_thumbnail_id', $attachmentId);
            }
        }
    }
        return $attachmentId;
    }
    /**
     * Method to Update Woo Product and sync market id to BC
     *
     * @return void
     */
    public function update_on_post($post_id)
    {
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.

        if ($_REQUEST['action'] == 'editpost' && $_REQUEST['post_type'] == 'product') {

            $listID = get_post_meta( $post_id, 'ListingId')[0];
        
           
           if(empty($listID)){
            $term = get_term_by('term_id', $_REQUEST['tax_input']['product_cat'][1], 'product_cat');

                        if (!empty($term)) {
                            $term_id = $term->term_id;
                            $term_name = $term->name;
                            $term_slug = $term->slug;
                            '';
                        }
                      
                    if($_REQUEST['fc-trademeprice-product-page']['fc_list_type'] == 0){
                        $rprice = $_REQUEST['_sale_price']; 
                        
                    }
                    
                    else{
                        $rprice = 0; 
                    } 
                    if($_REQUEST['fc-trademeprice-product-page']['fc_list_type'] == 1){
                        $bprice = $_REQUEST['_sale_price']; 
                        $bwasprice = $_REQUEST['_regular_price']; 
                        $bclear = 'true';
                    }
                    
                    else{
                        $bprice = $_REQUEST['_sale_price']; 
                        $bwasprice = 0; 
                        $bclear = 'false';
                    }  

                    if(!empty($_REQUEST['attribute_names'])){
                      $attributes = '"Attributes": [';
                   $count = count($_REQUEST['attribute_names']);
                   $i = 1;
                    foreach($_REQUEST['attribute_names'] as $key => $attr){
                        
                        if($count==$i++){
                        
                            $attributes .= '{
                                "Name": "'.$attr.'",
                                "DisplayName": "'.$attr.'",
                                "Value": "'.$_REQUEST['attribute_values'][$key] .'",
                                "Type": 0,
                               
                                "IsRequiredForSell": false,
                                
                                "DisplayValue": "'.$_REQUEST['attribute_values'][$key] .'"
                            }';
                        }else{
                            $attributes .= '{
                                "Name": "'.$attr.'",
                                "DisplayName": "'.$attr.'",
                                "Value": "'.$_REQUEST['attribute_values'][$key] .'",
                                "Type": 0,
                               
                                "IsRequiredForSell": false,
                                
                                "DisplayValue": "'.$_REQUEST['attribute_values'][$key] .'"
                            },';
                        }
                    }
                    $attributes .= '],';
                }
                    $photos = ' "Photos": [';
                    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
                    $gallery = get_post_gallery_images($post_id);
                     
                         $photos .=   '{
                            "Key": 123,
                            "Value": {
                                "FullSize" : "'.$image_url[0].'"
                            }
                        }';
                        foreach( explode(',',$_REQUEST['product_image_gallery']) as $attachment_id ) {   
                            if(empty($attachment_id )){
                                $attachment_id =  rand(3666,6556);
                            }
                            $photos .=   ',{
                                "Key": '.$attachment_id .',
                                "Value": {
                                    "FullSize" : "'.wp_get_attachment_url( $attachment_id ).'"
                                }
                            }';
                        }
                         $photos .= ']';
                         !empty($_REQUEST['_width']) ? $_REQUEST['_width'] : $_REQUEST['_width'] = 0 ;
                         !empty($_REQUEST['_height']) ? $_REQUEST['_height'] : $_REQUEST['_height'] = 0 ;
                         !empty($_REQUEST['_length']) ? $_REQUEST['_length'] : $_REQUEST['_length'] = 0 ;
            $json = '{
                "Category": "'.$term_slug.'-",
                "Title": "'.$_REQUEST['post_title'].'",
                "Subtitle": "ABC",
                "Description": [
                    "'.$_REQUEST['content'].'"
                   
                ],
                "StartPrice": 0,
                "ReservePrice": '.$rprice.',
                "BuyNowPrice": '.$bprice.',
                "Duration": '.$_REQUEST['fc-trademeprice-product-page']['fc_duration'].',
                "EndDateTime": "\/Date('.strtotime(date('c')).')\/",
                "Pickup": '.$_REQUEST['fc-trademeshipping-product-page']['fc_list_pick-ups'].',
                
                "IsBrandNew": '.$_REQUEST['fc-trademedetail-product-page']['fc_list_condition'].',
                
                "Quantity": '.$_REQUEST['_stock'].',
                "IsClearance": '.$bclear.',
                
                "ShippingOptions": [
                    {
                        "Type": 1,
                        "Price": '.$_REQUEST['_sale_price'].',
                        "Method": "ABC",
                        "ShippingId": 123,
                        "TaxesIncluded": [
                            {
                                "Type": 1,
                                "Country": "ABC",
                                "Name": "ABC",
                                "FlatRate": 5.0,
                                "Description": "ABC",
                                
                                "TaxAmount": 5.0,
                                "WasPriceTaxAmount": 4.0
                            }
                            
                        ]
                    }
                  
                ],
                "PaymentMethods": [
                   1
                    
                ],
                '.$attributes.'
               
                "ExternalReferenceId": "'.$_REQUEST['post_ID'].'",

                
              
                "SKU": "'.$_REQUEST['_sku'].'",

              
                "WasPrice": '.$bwasprice.',
              
               
                "ShippingCalculatorInputs": {
                    "IsBoxType": false,
                    "Width": '.$_REQUEST['_width'].',
                    "Height": '.$_REQUEST['_height'].',
                    "Depth": '.$_REQUEST['_length'].',
                    "IsSignatureRequired": false,
                    "PickupLocalityId": 123,
                    "IsRural": false,
                    "PackagingOption": 1,
                    "WeightOption": 1,
                    "FilterOption": 0
                },
              
             
              
                
                
               '.$photos.'
            }';
            $url = 'https://api.trademe.co.nz/v1/Selling.json';

			$header = $this->header;
            $header = array_merge($header,array('Content-Type' => 'application/json'));
			$method = 'POST';
			$post_data = $json;
			
			

			$data = $this->api($url, $header, $method, $post_data);
			
			$data = json_decode($data['body'],true);
            
            update_post_meta( $post_id, 'ListingId', $data['ListingId']);
        
        }

        }
    }
       /**
     * Method to Get Woo Custom Comments 
     *
     * @return void
     */
    public function get_custom_comment($post_id,$list_id,$type)
    {
        global $wpdb;
        $query = "SELECT * 
                FROM $wpdb->comments 
                INNER JOIN $wpdb->commentmeta ON $wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id
                WHERE $wpdb->comments.comment_post_ID = $post_id AND $wpdb->comments.comment_type = $type AND $wpdb->commentmeta.meta_value = $list_id
                ";
        $results = $wpdb->get_results($query);
        return  $results;
            
    }
    /**
     * Method to Delete Woo Product and sync market error to BC
     *
     * @return void
     */
    public function delete_on_post($post_id)
    {



    
       
    }
    /**
     * Method to Add Woo Category and sync to BC
     *
     * @return void
     */
    public function add_on_category($taxonomy)
    {
        //if ( $_REQUEST['taxonomy'] == 'product_cat ') {
       
        
        
        //}
    }
    /**
     * Method to Update Woo Category and sync to BC
     *
     * @return void
     */
    public function update_on_category($term_id)
    {

    
    }
    /**
     * Method to Delete Woo Category and sync to BC
     *
     * @return void
     */
    public function delete_on_category($term_id)
    {
      
        //die;
        //
    }
    /**
     * Method to Update Woo Order and sync to BC
     *
     * @return void
     */
    public function update_on_order($post_id)
    {
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && 'DOING_AUTOSAVE') {
            return;
        }
    //    echo '<pre>';
    //     print_r($_REQUEST);
    //     die;

    }
    /**
     * Method to Add Woo Order and sync to BC
     *
     * @return void
     */
    public function add_order($order_data,$product_id)
    {


        
        global $woocommerce;
             // Create product
    
    
     $_SERVER['REMOTE_ADDR'];
     // Required, else wc_create_order throws an exception
     $order = wc_create_order();
     // Add order products
     $item_id = $order->add_product( get_product($product_id), $order_data['QuantitySold']);
     // Set billing address
     $billing_address = array('country' => $order_data['DeliveryAddress']['Country'],
      'first_name' => explode(' ',$order_data['DeliveryAddress']['Name'])[0], 
      'last_name' => explode(' ',$order_data['DeliveryAddress']['Name'])[1], 
      'company' => '', 
      'address_1' => $order_data['DeliveryAddress']['Address1'],
      'address_2' => $order_data['DeliveryAddress']['Address2'],
        'postcode' => $order_data['DeliveryAddress']['Postcode'],
         'city' => $order_data['DeliveryAddress']['City'], 
         'state' => $order_data['DeliveryAddress']['Suburb'], 
         'email' => $order_data['Buyer']['Email'], 
         'phone' => $order_data['DeliveryAddress']['PhoneNumber']);

     $order->set_address($billing_address, 'billing');
    
     // Set totals
     $order->set_total($order_data['TotalShippingPrice'], 'shipping');

     
     
     $order->set_total($order_data['TotalSalePrice'], 'total');
     $note = __($order_data['MessageFromBuyer']);

     // Add the note
     $order->add_order_note( $note );
     $note = __($order_data['PaymentInstructions']);

     // Add the note
     $order->add_order_note( $note ,1);
     update_post_meta( $order->id, 'PurchaseId', $order_data['PurchaseId'] ); 
     update_post_meta( $order->id, 'Method', $order_data['Method'] ); 
     update_post_meta( $order->id, 'PaymentType', $order_data['PaymentDetails']['PaymentType'] ); 
     update_post_meta( $order->id, 'PaymentMethodFee', $order_data['PaymentDetails']['PaymentMethodFee'] ); 
     
     update_post_meta( $order->id, 'SelectedShipping', $order_data['SelectedShipping']); 
     update_post_meta( $order->id, 'ShippingType',$order_data['ShippingType'] ); 
     update_post_meta( $order->id, 'PaymentMethodUsed', $order_data['PaymentMethodUsed'] ); 
     update_post_meta( $order->id, 'PaymentMethod', $order_data['PaymentMethod'] ); 
     // 4 x $10 simple helper product
     return wc_get_order($order->id);
    }
    /**
     * Method to Update Woo Order and sync to BC
     *
     * @return void
     */
    public function update_order($order_id)
    {

         $order_id;
        if (!$order_id) {
            return;
        }
        if (is_admin() || !empty($order_id)) {
            $order = wc_get_order($order_id);
            
        
        }
    }
    /**
     * Method to Convert Woo Order to json and sync to BC
     *
     * @return void
     */
    public function jsonConvert($order,$order_status)
    {

        $data = $order->get_data();


        $user = $order->get_user();
        $user_roles = $user->roles;

        $order_items = $order->get_items();



        foreach ($order_items as $item_id => $item) {

            $postMeta = get_post_meta($item->get_product_id(), 'fc-bookcloud-integration');

            if (!empty($postMeta[0]['fc-fieldset-option']['fc-id'])) {
                $item_id = $postMeta[0]['fc-fieldset-option']['fc-id'];
            }
            $product  = $item->get_product();

            $items[] = array(
                'mp_id' => '',
                'productcode' => $item_id,
                'description' => $item->get_name(),
                'quantity' => $item->get_quantity(),
                'price' => $item->get_total(),
                'iva' => $item->get_total_tax(),
                'rate' => '',
                'discount' => '',
                'subtotal' => $item->get_subtotal(),
            );
        }
        if ($data['customer_id'] == 0) {
            $data['customer_id'] = $data['id'] . $data['customer_id'];
            $user_roles[0] = 'customer';
        }
        $bookcloud_api = get_option('fc-bookcloud-integration-options-admin-page');
      
        foreach($bookcloud_api['fc-sync-repeater'] as $status){
            
            if(str_replace('wc-','',$status['fc_wc_status']) == str_replace('wc-','',$order_status)){
                $order_status = $status['fc_bc_status'];
            }
        }
        return  $json = '{
        "action": "addOrder",
        "params": {
            "market": "' . $bookcloud_api['fc-bi-fieldset']['bi-btn-market'] . '",
            "order": [
                {
            "mp_id":' . $data['id'] . ',
            "date":' . time() . ',
            "codcig": "",
            "customer": {
                "mp_id": "",
                "type": "PA",
                "vatcode_state": "",
                "vatcode": "",
                "taxcode": "",
                "codcup": "",
                "sdicode": "",
                "emailpec": "",
                "company": "' . $data['billing']['company'] . '",
                "firstname": "' . $data['billing']['first_name'] . '",
                "lastname": "' . $data['billing']['last_name'] . '",
                "address": "' . $data['billing']['address_1'] . '",
                "zip": "' . $data['billing']['postcode'] . '",
                "city": "' . $data['billing']['city'] . '",
                "zone": "' . $data['billing']['state'] . '",
                "country": "' . $data['billing']['country'] . '",
                "email": "' . $data['billing']['email'] . '",
                "phone": "' . $data['billing']['phone'] . '"
            },
            "address_ship": {
                "id": "",
                "type": "",
                "vatcode_state": "",
                "vatcode": "",
                "taxcode": "",
                "codcup": "",
                "sdicode": "",
                "emailpec": "",
                "company": "' . $data['shipping']['company'] . '",
                "firstname": "' . $data['shipping']['first_name'] . '",
                "lastname": "' . $data['shipping']['last_name'] . '",
                "address": "' . $data['shipping']['address_1'] . '",
                "zip": "' . $data['shipping']['postcode'] . '",
                "city": "' . $data['shipping']['city'] . '",
                "zone": "' . $data['shipping']['state'] . '",
                "country": "' . $data['shipping']['country'] . '",
                "email": "' . $data['billing']['email'] . '",
                "phone": "' . $data['billing']['phone'] . '"
            },
            "origin": "' . $data['id'] . '",
            "status": "'.$order_status.'",
            "received": "",
            "payment": "' . $data['payment_method_title'] . '",
            "payment_mode": "' . $data['payment_method'] . '",
            "payment_date": "",
            "financial_institute": "",
            "iban": "",
            "shipping": "'.$order->get_shipping_total().'",
            "shipping_tracking": "",
            "note": "' . $data['customer_note'] . '",
            "tax": ' . $data['total_tax'] . ',
            "subtotal": null,
            "total":' . $data['total'] . ',
            "items":' . json_encode($items) . '
                                }
                            ]
                        }
                        }';
    }

    /**
     * Method to sync specific action to BC
     *
     * @return void
     */
    public function sync($type,$data)
    {
        //ini_set('display_errors', 1);

        
            
        if ($_REQUEST['type'] == 'order_sync') {

           
            die;
        }

        if ($_REQUEST['type'] == 'sync') {

           
            die;
        }

        if ($_REQUEST['type'] == 'sync_mkt_category') {

       
        }

        if ($_REQUEST['type'] == 'update_product_market_id') {

 
        }

        if ($type == 'sync_tm_category') {

            
                   
            $this->set_category($data,'');
           

   
        }
        if ($type == 'sync_unQ') {

            
                   
            $this->add_unQ($data);
           

   
        }
      
    }
    function add_unQ($data){
                echo '<pre>';
                $unansQA =  get_option( 'fc_trademe_unans_ques' );
                print_r($unansQA);
                die;
                foreach($data as $gdata)
                $CommentDate = trim(str_replace(')','',str_replace('Date(','',str_replace('/','',$gdata['CommentDate']))));
			
                
                $listdata[] = array(
                    'ListingId' => $gdata['ListingId'],
                    'ListingQuestionId' => $gdata['ListingQuestionId'],
                    'Comment' => $gdata['Comment'],
                    'CommentDate' => date('c',ceil($CommentDate / 1000))
                );
				print_r($listdata);
               
				update_option('fc_trademe_unans_ques', $listdata);
                
    }
    function set_category($data,$parent_term_id){
        $i = 0;
        foreach($data as $cat_data){

        if (!empty($cat_data['Name']) ) {

            
                $term = get_term_by('slug', $cat_data['Number'], 'product_cat');
                if (!empty($term)) {
                    $term_id = $term->term_id;
                    $term_name = $term->name;
                    $parent_id = $term->parent_id;
                    $term_slug = $term->slug;
                }
            
           

            if (!empty($term_name) && sanitize_title(trim($term_name)) ==  sanitize_title($cat_data['Name']) && $term_id !== 1) {
              
                echo  '<br>';
               

                echo 'Updated the Category to WP ID ' . $term_id;
                '<br>';
               

                wp_update_term($term_id, 'product_cat', array(
                    'description' => ' ', // optional
                                         // optional
                    'name' =>  $cat_data['Name'] 
                ));
                if(isset($cat_data['Subcategories'])){
                    if($parent_id == 0){
                        $parent_term_id = $term_id;
                    }else{
                       
                    }
                   $this->set_category($cat_data['Subcategories'],$parent_term_id );
                }
            } else {



                echo 'Added the Category to WP';
                echo  '<br>';
                echo $cat_data['Name'];
                if(!empty($parent_term_id)){
                    echo $parent_term_id ;
                }else{
                    $parent_term_id = 0;
                }
                $resp = wp_insert_term($cat_data['Name'], 'product_cat', array(
                    'description' => '', // optional
                    'parent' => $parent_term_id , // optional
                    'slug' => $cat_data['Number'] 

                ));

               
                echo '<pre>';
                
                if(isset($cat_data['Subcategories'])){
                   //print_r($cat_data);
                    
                    $this->set_category($cat_data['Subcategories'], $resp['term_id']);
                }
                
            }
            echo  '<br>';

            echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
            echo  '<br>';
        }else{
            $term = get_term_by('slug', $cat_data['Number'] , 'product_cat');
            echo 'Deleted the Category to WP';
                echo  '<br>';
                echo sanitize_title($cat_data['Name']);
                $term_id = $term->term_id;
                wp_delete_term($term_id,'product_cat');
        }
       
        
        if(1==$i++){
        return;
        }
    }
}
}
