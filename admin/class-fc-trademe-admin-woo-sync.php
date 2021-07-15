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
                    
                    $comments =  $this->get_custom_comment($post_id,$question['ListingQuestionId'])[0];
                    
                    
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


            $_REQUEST['type'] = 'update_product_market_id';

            $_REQUEST['interval_sec'] = 3;
            $this->check_sync();
            // '<pre>';
            // print_r($_REQUEST);
            // die;

        }
    }
       /**
     * Method to Get Woo Custom Comments 
     *
     * @return void
     */
    public function get_custom_comment($post_id,$list_id)
    {
        global $wpdb;
        $query = "SELECT * 
                FROM $wpdb->comments 
                INNER JOIN $wpdb->commentmeta ON $wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id
                WHERE $wpdb->comments.comment_post_ID = $post_id AND $wpdb->comments.comment_type = 'comment' AND $wpdb->commentmeta.meta_value = $list_id
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
    public function add_order($order_id)
    {


        if (!$order_id) {
            return;
        }
        if (is_checkout() || !empty(is_wc_endpoint_url('order-received')) || !empty($order_id)) {
            $order = wc_get_order($order_id);
       
        }
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
