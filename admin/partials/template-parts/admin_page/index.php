<div>


   <div class="search_products">

      <ul class="subsubsub">
         <li class="all" style="display: none;"><a href="#" class="current" aria-current="page">All <span class="count">(9)</span></a> |</li>
         <li class="publish"><a href="#">All <span class="count"> ( 1-18 of 8704 )</span></a> |</li>

      </ul>

      <div class="search-box">
         <label class="screen-reader-text" for="post-search-input">Search products:</label>
         <input type="search" id="post-search-input" name="s" value="">
         <input type="submit" id="search-submit" class="button" value="Search products">
         <button type="submit" id="Add products" class="button add_products" value="Add Products">Add Products</button>
      </div>


   </div>
   <div class="tablenav top">


      <div class="alignleft actions bulkactions">
         <label for="bulk-action-selector-top" class="screen-reader-text"></label>
         <select name="action" id="bulk-action-selector-top">
            <option value="">Product Filters</option>
            <option value="" class="">By State</option>
            <option value="">By Brand</option>
            <option value="">By Category</option>
            <option value="">By Tag</option>
         </select>
         <input type="submit" id="doaction" class="button action" value="Apply">
      </div>

      <div class="alignleft actions">
         <select name="product_cat" id="product_cat" class="dropdown_product_cat">
            <option value="" selected="selected">Discounts</option>
            <option class="level-0" value="burgers">Active Discounts</option>
            <option class="level-0" value="pizza">Expired Discounts</option>

         </select>

         <select name="product_type" id="dropdown_product_type">
            <option value="">Manage</option>
            <option value="Categories">Categories</option>
            <option value="Brands"> Brands</option>
            <option value="Tags"> Tags</option>
            <option value="Tag Group">Tag Group</option>
            <option value="Catalogs">Catalogs</option>
            <option value="Conditions">Conditions</option>
            <option value="Overlays">Overlays</option>
         </select>

         <select name="stock_status">
            <option value="">Filter by stock status</option>
            <option value="instock">In stock</option>
            <option value="outofstock">Out of stock</option>
            <option value="onbackorder">On backorder</option>
         </select>

         <input type="submit" name="filter_action" id="" class="button" value="Filter">
      </div>

      <div class="pagination">
         <a href="#">&laquo;</a>
         <a href="#">1</a>
         <a href="#" class="active">2</a>
         <a href="#">3</a>
         <a href="#">4</a>
         <a href="#">5</a>
         <a href="#">6</a>
         <a href="#">&raquo;</a>
      </div>
      <br class="clear">
   </div>


   <table>
      <tr>
         <th><input type="checkbox" name="">All</th>
         <th></th>
         <th>Status</th>
         <th>Code</th>
         <th>Name</th>
         <th>Price</th>
         <th>Stock</th>
         <th>Expiry</th>
         <th>Location</th>
         <th>Categories</th>
      </tr>
      <?php foreach($product_data['product_data'] as $data): 
               $product               = wc_get_product( $data['product_id']);
               $product_thumbnail_url = get_the_post_thumbnail_url( $product_id, 'medium' );
               $product_title         = $product->get_name();
               $product_link          = get_the_permalink();
               $sale_price            = $product->get_sale_price();
               $regular_price         = $product->get_regular_price();
               $is_product_on_sale    = $product->is_on_sale();
               $is_product_in_stock   = $product->is_in_stock();
               $product_price         = $product->get_price_html();
               $discount_percent      = ! empty( $sale_price ) ? floatval( ( $regular_price - $sale_price ) / $regular_price * 100 )  : 0;
         ?>
      <tr>
         <td><input type="checkbox" name=""></td>
         <td><img class="tabelImg" src="<?php echo esc_url( $product_thumbnail_url ); ?>"></td>
         <td><?php echo  $product_title; ?></td>
         <td><?php echo $data['product_id']; ?></td>
         <td>Kogan Induction Cooktop- 600m</td>
         <td><?php echo wp_kses_post( $product_price ); ?></td>
         <td>1</td>
         <td></td>
         <td></td>
         <td>Kogan Induction Cookto</td>
      </tr>
      <?php endforeach; ?>

   </table>

</div>

