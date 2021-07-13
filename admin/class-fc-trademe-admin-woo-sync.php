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
class Fc_Trademe_Admin_Woo_Sync extends Fc_Trademe_API
{
    function __construct()
    {
    }
    /**
     * Method to Add/Update Bookcloud Products to Woo
     *
     * @return void
     */
    public function add_update_wooProduct($productData, $post_id)
    {

        //BookCloud Panel option
        if (empty($post_id)) {
            if (empty($productData['description'])) {
                $productData['description'] = 'No data';
            }
            $post = array(
                'post_author' => get_current_user_id(),
                'post_content' => $productData['description'],
                'post_status' => "publish",
                'post_title' => $productData['title'],
                'post_parent' => '',
                'post_type' => "product",
            );
            // print_r($post);
            //Create post
            $post_id = wp_insert_post($post);
            echo ' Fetched The Item and id is : ' . $post_id;
        } else {
            $post = array(
                'ID' => esc_sql($post_id),
                'post_content' => wp_kses_post($productData['description']),
                'post_title' => wp_strip_all_tags($productData['title'])
            );
            $result = wp_update_post($post, true);
        }



        wp_set_object_terms($post_id, intval($productData['category']), 'product_cat');
        wp_set_object_terms($post_id, 'simple', 'product_type');
        $tags = explode(',', $productData['subjects']);
        wp_set_object_terms($post_id, $tags, 'product_tag');
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_bcID', $productData['id']);
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, 'total_sales', '0');
        update_post_meta($post_id, '_downloadable', 'no');
        update_post_meta($post_id, '_virtual', 'no');

        update_post_meta($post_id, '_regular_price', $productData['price']['IT']);
        update_post_meta($post_id, '_sale_price', $productData['discount']);
        update_post_meta($post_id, '_purchase_note', "");
        update_post_meta($post_id, '_featured', "no");
        update_post_meta($post_id, '_weight', $productData['weight']);
        update_post_meta($post_id, '_length', "");
        update_post_meta($post_id, '_width', "");
        update_post_meta($post_id, '_height', "");
        update_post_meta($post_id, '_sku', $productData['sku']);
        update_post_meta($post_id, '_product_attributes', array());
        update_post_meta($post_id, '_sale_price_dates_from', "");
        update_post_meta($post_id, '_sale_price_dates_to', "");
        update_post_meta($post_id, '_price', $productData['price']['IT']);
        update_post_meta($post_id, '_sold_individually', "");
        update_post_meta($post_id, '_manage_stock', "yes");
        update_post_meta($post_id, '_backorders', "no");
        update_post_meta($post_id, '_stock', $productData['stock']);
        $bookcloud_api = get_option('fc-bookcloud-integration-options-admin-page');
        $array = array(
            'fc-fieldset-option' => array(
                'fc-id' => $productData['id'],
                'fc-type' => $productData['type'],
                'fc-isbn' => $productData['isbn'],
                'fc-ean' => $productData['ean'],
                'fc-market' => 'WOO_' . $post_id,
                'fc-language' => $productData['language'],
                'fc-pages' => $productData['pages'],
                'fc-conditions' => $productData['conditions'],
                'fc-binding' => $productData['binding'],
                'fc-created_at' => date('Y/m/d', $productData['created_at']),
                'fc-updated_at' => date('Y/m/d', $productData['updated_at']),
            ),
            'fc-fieldset-info' => array(
                'fc-author' => $productData['author'],
                'fc-curator' => $productData['curator'],
                'fc-translator' => $productData['translator'],
                'fc-illustrator' => $productData['illustrator'],
                'fc-ispartof' => $productData['ispartof'],
                'fc-publishing_year' => $productData['publishing_year'],
                'fc-publishing_place' => $productData['publishing_place'],
                'fc-publisher' => $productData['publisher'],
                'fc-edition' => $productData['edition'],
                'fc-collection' => $productData['collection'],
                'fc-volumes' => $productData['volumes'],
            )
        );
        update_post_meta($post_id, 'fc-bookcloud-integration', $array);
        $array = array(
            'fc-fieldset-info' => array(
                'fc-isbn' => $productData['isbn'],
                'fc-ean' => $productData['ean'],
                'fc-pages' => $productData['pages'],

                'fc-publishing_year' => $productData['publishing_year'],
                'fc-publishing_place' => $productData['publishing_place'],

            )
        );
        update_post_meta($post_id, 'fc-bookcloud-integration2', $array);
        wp_set_object_terms($post_id, $productData['type'], 'bc_type');
        wp_set_object_terms($post_id, $productData['author'], 'bc_author');
        wp_set_object_terms($post_id, $productData['curator'], 'bc_editor');
        wp_set_object_terms($post_id, $productData['translator'], 'bc_translator');
        wp_set_object_terms($post_id, $productData['illustrator'], 'bc_illustrator');
        wp_set_object_terms($post_id, $productData['publisher'], 'bc_publisher');
        wp_set_object_terms($post_id, $productData['volumes'], 'bc_volumes');
        wp_set_object_terms($post_id, $productData['collection'], 'bc_collection');
        wp_set_object_terms($post_id, $productData['language'], 'bc_language');
        wp_set_object_terms($post_id, $productData['conditions'], 'bc_condition');
        wp_set_object_terms($post_id, $productData['ispartof'], 'bc_ispartof');
        wp_set_object_terms($post_id, $productData['binding'], 'bc_binding');
        wp_set_object_terms($post_id, $productData['edition'], 'bc_edition');



        // // file paths will be stored in an array keyed off md5(file path)

        $this->upload_image($productData['images'][0], $post_id, 'main');
        $inc = 0;
        foreach ($productData['images'] as $key => $imgurl) {

            if ($key !== 0) {
                $attachmentId[] =  $this->upload_image($imgurl, $post_id, 'gallery');
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
        $image = "";
        if ($url != "") {

            $file = array();
            $file['name'] = $url;
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
        $_REQUEST['type'] = 'sync_mkt_category';

        $_REQUEST['interval_sec'] = 1;
        $this->check_sync();
        
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
    public function check_sync()
    {
        //ini_set('display_errors', 1);

        $bookcloud_api = get_option('fc-bookcloud-integration-options-admin-page');
            
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

        if ($_REQUEST['type'] == 'sync_bc_category') {



   
        }

        if ($_REQUEST['type'] == 'sync_overall_category') {

            $_REQUEST['type'] = 'sync_bc_category';
            $this->check_sync();
            $_REQUEST['type'] = 'sync_bc_category';
            $this->check_sync();
        }
    }

   
}
