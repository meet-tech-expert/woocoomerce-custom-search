<?php
get_header(); ?>
<?php
global $wpdb;

$table = $wpdb->prefix.'search_forms';
$productTable = $wpdb->prefix.'search_form_products';

$keyword = urldecode(get_query_var('keywords'));
$no_of_records_per_page = urldecode(get_query_var('count'));

if (! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	exit;
}
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
 $offset = ($pageno-1) * $no_of_records_per_page;
 $sql = "SELECT * FROM $table AS sf JOIN $productTable AS pt ON sf.id = pt.form_id WHERE sf.keyword='$keyword' ORDER BY pt.product_order ASC  LIMIT $offset , $no_of_records_per_page";



$totalsql = "SELECT * FROM $table AS sf JOIN $productTable AS pt ON sf.id = pt.form_id WHERE sf.keyword='$keyword' ORDER BY pt.product_order ASC";

$results = $wpdb->get_results($sql,'ARRAY_A');

$totalresults = $wpdb->get_results($totalsql,'ARRAY_A');

//$total_pages_sql = $sql;
 $total_rows = count($totalresults);
 $total_pages = ceil($total_rows / $no_of_records_per_page);
//print_r($results);
?>
<div id="main-content" class="site-main light">
    <div id="nasa-breadcrumb-site" class="bread nasa-breadcrumb nasa-breadcrumb-has-bg nasa-parallax nasa-stellared" style="background: url(&quot;<?php echo site_url(); ?>/wp-content/uploads/2018/10/new_banner_top.jpg&quot;) -20px -77.6px repeat-y; height: 160px; color: rgb(0, 0, 0);" data-stellar-background-ratio="0.6">
            <div class="row">
                <div class="large-12 columns">
                    <div class="breadcrumb-row">
                        <h2>ショップ</h2><h3 class="breadcrumb"><a class="home" href="<?php echo site_url();?>">Home</a><span class="fa fa-angle-right"></span></h3>                    </div>
                </div>
            </div>
    </div>
    <div class="row fullwidth category-page">
        
        <div class="large-12 columns">
            <div class="row filters-container nasa-filter-wrap">
                <div class="hide-for-small large-4 columns">
                    <input type="hidden" name="nasa-pos-showing-info" value="1"><div class="showing_info_top"><p class="woocommerce-result-count">
    	Showing <?php echo count($results);?> results</p>
    </div>      </div>
                <div class="large-4 text-center columns">
                    <?php echo $results[0]['text_before'];?>
                </div>
                <div class="columns"></div>
                
            </div>
        </div>
        
        <div class="nasa-products-page-wrap large-9 columns left has-sidebar">
            <div class="nasa-products-page-wrap large-12 columns left has-sidebar" style="margin-bottom: 20px;">
                <div class="nasa-archive-product-warp">
                    <div class="row">
                        <div class="large-12 columns nasa-content-page-products">
                            <div class="nasa-row-child-clear-none thumb products grid">
                                <?php 
                                if(!empty($results)){
                    	        foreach($results as $prod){
                    				$product_id = $prod['product_id']; 
                    				$product = new WC_product($product_id);
                    				 $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('250','250') );
                    				?>
                                <div class="product-warp-item large-3 small-12 medium-6 columns">
                                    <div class="wow fadeInUp product-item grid hover-fade" data-wow-duration="1s" data-wow-delay="300ms" data-wow="fadeInUp">
                                        <div class="inner-wrap nasa-title-bottom">
                                         <div class="product-outner">
                                            <div class="product-inner">
               <div class="product-img hover-overlay">
                  <a href="<?php  echo $product->get_permalink(); ?>" title="<?php echo $prod['name'];?>">
                     <div class="main-img"><img width="247" height="300" src="<?php echo $image[0];?>" class="attachment-shop_catalog size-shop_catalog" alt="<?php echo $prod['name'];?>"></div>
                     <div class="back-img back"><img width="247" height="300" src="<?php echo $image[0];?>" class="attachment-shop_catalog size-shop_catalog" alt="<?php echo $prod['name'];?>"></div>
                  </a>
               </div>
               <div class="nasa-product-list hidden-tag">
                  <span class="price"><?php echo $product->get_price_html();?><span class="variableshopmessage"></span></span>                    
                  <p class="nasa-list-stock-status hidden-tag instock">
                     在庫状況:<span>ストック有り</span>                    
                  </p>
                  <!-- Product interactions button button for list -->
                  <div class="nasa-group-btn-in-list">
                     <div class="product-summary">
                        <div class="product-interactions">
                           <div class="add-to-cart-btn">
                              <div class="btn-link"><a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow" data-quantity="1" data-product_id="<?php echo $product_id; ?>" data-product_sku="" class=" product_type_variable add-to-cart-grid button small" data-head_type="1" title="オプションを選択"><span class="cart-icon pe-icon pe-7s-cart"></span><span class="add_to_cart_text">オプションを選択</span><span class="cart-icon-handle"></span></a></div>
                           </div>
                           <div class="btn-wishlist tip-top" data-prod="<?php echo $product_id; ?>" data-tip="<?php echo $prod['name'];?>" title="<?php echo $prod['name'];?>">
                              <div class="btn-link">
                                 <div class="wishlist-icon">
                                    <span class="nasa-icon icon-nasa-like"></span>
                                    <span class="hidden-tag nasa-icon-text no-added">ほしい物リスト</span>
                                 </div>
                              </div>
                           </div>
                           <div class="add-to-link hidden-tag"> 
                              <div class="yith-wcwl-add-to-wishlist add-to-wishlist-2530">
                                 <div class="yith-wcwl-add-button show" style="display:block">
                                    <a href="/shop/?add_to_wishlist=<?php echo $product_id; ?>" rel="nofollow" data-product-id="<?php echo $product_id; ?>" data-product-type="variable" class="add_to_wishlist">
                                    ほしい物リストに追加</a>
                                    <img src="<?php echo site_url(); ?>/wp-content/plugins/yith-woocommerce-wishlist/assets/images/wpspin_light.gif" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden">
                                 </div>
                                 <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
                                    <span class="feedback">追加しました。</span>
                                    <a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow">
                                    ほしい物リストを見る	        </a>
                                 </div>
                                 <div class="yith-wcwl-wishlistexistsbrowse hide" style="display:none">
                                    <span class="feedback">この商品はほしい物リストにあります。</span>
                                    <a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow">
                                    ほしい物リストを見る	        </a>
                                 </div>
                                 <div style="clear:both"></div>
                                 <div class="yith-wcwl-wishlistaddresponse"></div>
                              </div>
                              <div class="clear"></div>
                           </div>
                           <div class="quick-view tip-top" data-prod="<?php echo $product_id; ?>" data-tip="クイック表示" data-head_type="1" title="<?php echo $prod['name'];?>" data-product_type="variable">
                              <div class="btn-link">
                                 <div class="quick-view-icon">
                                    <span class="pe-icon pe-7s-look"></span>
                                    <span class="hidden-tag nasa-icon-text">クイック表示</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Product interactions button-->
               </div>
               <div class="info">
                  <div class="nasa-list-category hidden-tag">
                     <a href="<?php  echo $product->get_permalink(); ?>" rel="tag">性病</a>                    
                  </div>
                  <div class="name hidden-tag nasa-name">
                     <a href="<?php  echo $product->get_permalink(); ?>" title="<?php echo $prod['name'];?>">
                     <?php echo $prod['name'];?></a>
                  </div>
                  <div class="name">
                     <a href="<?php  echo $product->get_permalink(); ?>" title="<?php echo $prod['name'];?>">
                     <?php echo $prod['name'];?>    </a>
                  </div>
                  <div class="info_main">
                     <span class="price"><?php echo $product->get_price_html();?><span class="variableshopmessage"></span></span>                        
                     <hr class="nasa-list-hr hidden-tag">
                     <div class="product-des">
                        <?php  //echo $prod['description']; ?>
                     </div>
                  </div>
                  
                  <div class="nasa-product-grid">
                     <!-- Product interactions button for grid -->
                     <div class="product-summary" style="">
                        <div class="product-interactions"> 
                           <div class="add-to-cart-btn"  style="">
                              <div class="btn-link"><a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow" data-quantity="1" data-product_id="<?php echo $product_id; ?>" data-product_sku="" class=" product_type_variable add-to-cart-grid button small" data-head_type="1" title="オプションを選択"><span class="cart-icon pe-icon pe-7s-cart"></span><span class="add_to_cart_text">オプションを選択</span><span class="cart-icon-handle"></span></a></div>
                           </div>
                           <div class="btn-wishlist tip-top" data-prod="<?php echo $product_id; ?>" data-tip="ほしい物リスト" title="ほしい物リスト">
                              <div class="btn-link">
                                 <div class="wishlist-icon">
                                    <span class="nasa-icon icon-nasa-like"></span>
                                    <span class="hidden-tag nasa-icon-text no-added">ほしい物リスト</span>
                                 </div>
                              </div>
                           </div>
                           <div class="add-to-link hidden-tag">
                              <div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo $product_id; ?>">
                                 <div class="yith-wcwl-add-button show" style="display:block">
                                    <a href="/shop/?add_to_wishlist=<?php echo $product_id; ?>" rel="nofollow" data-product-id="<?php echo $product_id; ?>" data-product-type="variable" class="add_to_wishlist">
                                    ほしい物リストに追加</a>
                                    <img src="<?php echo site_url(); ?>/wp-content/plugins/yith-woocommerce-wishlist/assets/images/wpspin_light.gif" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden">
                                 </div>
                                 <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
                                    <span class="feedback">追加しました。</span>
                                    <a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow">
                                    ほしい物リストを見る	        </a>
                                 </div>
                                 <div class="yith-wcwl-wishlistexistsbrowse hide" style="display:none">
                                    <span class="feedback">この商品はほしい物リストにあります。</span>
                                    <a href="<?php  echo $product->get_permalink(); ?>" rel="nofollow">
                                    ほしい物リストを見る	        </a>
                                 </div>
                                 <div style="clear:both"></div>
                                 <div class="yith-wcwl-wishlistaddresponse"></div>
                              </div>
                              <div class="clear"></div>
                           </div>
                           <div class="quick-view tip-top" data-prod="<?php echo $product_id; ?>" data-tip="クイック表示" data-head_type="1" title="クイック表示" data-product_type="variable">
                              <div class="btn-link">
                                 <div class="quick-view-icon">
                                    <span class="pe-icon pe-7s-look"></span>
                                    <span class="hidden-tag nasa-icon-text">クイック表示</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Product interactions button-->
                  </div>
               </div>
            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php } }else{ ?>
                            	    	<p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
                            	   <?php }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="large-12 columns">
            <div class="row filters-container nasa-filter-wrap">
                <div class="hide-for-small large-4 columns">
                    <input type="hidden" name="nasa-pos-showing-info" value="1"><div class="showing_info_top"><p class="woocommerce-result-count">
    	Showing <?php echo count($results);?> results</p>
    </div>      </div>
                <div class="large-4 text-center columns">
                    <?php echo $results[0]['text_after'];?>
                </div>
                <div class="columns"></div>
                
            </div>
        </div>
            <?php	if(!empty($results)){?>
            <div class="row nasa-paginations-warp filters-container-down">
            <div class="large-12 columns">
            	<div class="nasa-pagination style-2">
            	<div class="page-number">
            		<ul class="page-numbers nasa-pagination-ajax">
            			<li><a class="" data-page="1" href="?pageno=1"><?php _e( 'First', 'custom-search' ); ?></a></li>
            			<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                        <a class="" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><?php _e( 'Prev', 'custom-search' ); ?></a>
                    </li>
                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><?php _e( 'Next', 'custom-search' ); ?></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><?php _e( 'Last', 'custom-search' ); ?></a></li>
            		</ul>                
            	</div>
            	<hr>
            </div>
            </div>
            </div>
            <?php } ?>
        
        </div>
        
        <div class="large-3 right columns col-sidebar"><?php get_sidebar(); ?></div>
        
        
    </div>
</div>    
<?php
get_footer();
?>