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
<div id="et-main-area">
<div id="main-content">
<div class="container">
<div id="content-area" class="clearfix">

<div id="left-area">
<div class="wrap cs-wrap">
<p class="woocommerce-result-count">Showing <?php echo count($results);?> results</p>
<?php if(!empty($results)){ ?>
<header class="woocommerce-products-header">
  <div class="woocommerce-products-header__title page-title"><?php echo $results[0]['text_before'];?></div>
</header>
<?php } ?>
<ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
	<?php	

		if(!empty($results)){
	        foreach($results as $prod){
				$product_id = $prod['product_id']; 
				$product = new WC_product($product_id);
				?>

				<li <?php echo wc_product_class('custom',$product_id); ?>>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('250','250') );?>
					<a href="<?php echo $product->get_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
					<span class="et_shop_image">
    				<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $product_id; ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="">
    				<span class="et_overlay"></span>
    				</span>

    				<h2 class="woocommerce-loop-product__title custom-pro-tite"><?php echo $prod['name'];?></h2>
					</a>
					<?php  echo $prod['description']; ?>
					<p class=""><?php  echo $prod['ingredients']; ?></p>
						<?php echo $product->get_price_html();?>
					<?php 
					 if ($product->is_in_stock() && $product->add_to_cart_url() != '') {
					 	echo do_shortcode('[add_to_cart id="'.$product_id.'" show_price = "false" style= "border:0px;padding: 5px;"]');
					 }
					?>

				</li>
			
			<?php } ?>
			
	<?php  }else{ ?>
	    	<p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
	   <?php }
    ?>

</ul>
<?php if(!empty($results)){ ?>
<header class="woocommerce-products-header">
  <div class="woocommerce-products-header__title page-title"><?php echo $results[0]['text_after'];?></div>
</header>
<?php } ?>
<?php	if(!empty($results)){?>
<ul class="pagination">
        <li><a href="?pageno=1"><?php _e( 'First', 'custom-search' ); ?></a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><?php _e( 'Prev', 'custom-search' ); ?></a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><?php _e( 'Next', 'custom-search' ); ?></a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>"><?php _e( 'Last', 'custom-search' ); ?></a></li>
</ul>
<?php }
    ?>
<!--/.products-->

</div>
</div>
	
		<?php get_sidebar(); ?>

</div>
</div>
</div>
</div>
<?php
get_footer();
?>