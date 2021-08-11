<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.forumcube.com/
 * @since      1.0.0
 *
 * @package    Fc_Trademe
 * @subpackage Fc_Trademe/admin/partials
 */
class Fc_Trademe_Admin_Display
{
    public function fc_display_trademe_product($product_data)
    {
?>
        <div class="csf-field csf-field-tabbed">
            <div class="csf-tabbed-nav">
                <a  class="csf-tabbed-active  product_listings" onclick="fc_tab('.product_listings','.product_listings-tabbed')" >Products Listings</a>
                <a  class="curr_product_listings" onclick="fc_tab('.curr_product_listings','.curr_product_listings-tabbed')" >Current Product Listings</a>
                <a  class="sold_product_listings" onclick="fc_tab('.sold_product_listings','.sold_product_listings-tabbed')" >Sold Product Listings</a>
                <a  class="unsold_product_listings" onclick="fc_tab('.unsold_product_listings','.unsold_product_listings-tabbed')" >Unsold Product Listings</a>
                <a  class="fixed_price_offers" onclick="fc_tab('.fixed_price_offers','.fixed_price_offers-tabbed')" >Fixed Price Offers</a>
                <a  class="unans_ques" onclick="fc_tab('.unans_ques','.unans_ques-tabbed')" >Unanswered Questions</a>
            </div>
            <div class=" csf-tabbed-sections">
                    <div class="csf-tabbed-section product_listings-tabbed">
                    <?php require_once plugin_dir_path(__FILE__) . 'template-parts/admin_page/index.php' ?>
                    </div>
                    <div class="csf-tabbed-section hidden curr_product_listings-tabbed">
                     
                    </div>
                    <div class="csf-tabbed-section hidden sold_product_listings-tabbed"></div>
                    <div class="csf-tabbed-section hidden unsold_product_listings-tabbed">
                      
                    </div>
                    <div class="csf-tabbed-section hidden fixed_price_offers-tabbed">
                      
                    </div>
                    <div class="csf-tabbed-section hidden unans_ques-tabbed">
                      
                    </div>
            </div>
            <div class="clear"></div>
        </div>
<?php
    }
    public function fc_display_trademein_auction()
    {
?>
        <div class="csf-field-tabbed">
            <div class="csf-tabbed-nav">
                <a  class="csf-tabbed-active existing" onclick="fc_tab('.existing','.existing-tabbed')" >Existing</a>
                <a  class=" new" onclick="fc_tab('.new','.new-tabbed')" >New</a>
            </div>
            <div class=" csf-tabbed-sections">
                    <div class="csf-tabbed-section existing-tabbed">
                    <?php require_once plugin_dir_path(__FILE__) . 'template-parts/admin_page/trademe.php' ?>
                    </div>
                    <div class=" new-tabbed csf-tabbed-section hidden">
                     <?php require_once plugin_dir_path(__FILE__) . 'template-parts/admin_page/trademeauction.php' ?>
                    </div>
                   
            </div>
            <div class="clear"></div>
        </div>
<?php
    }
}
?>

