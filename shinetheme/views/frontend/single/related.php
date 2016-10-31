<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 8/5/2016
 * Time: 11:22 AM
 */
$service=new WB_Service();
$service_type=$service->get_type();
$location_id = get_post_meta(get_the_ID(),'location_id',true);
$arg = array(
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'location_id',
			'value' => $location_id,
			'type' => 'CHAR',
			'compare' => '='
		),
		array(
			'key' => 'service_type',
			'value' => $service_type,
			'type' => 'CHAR',
			'compare' => '='
		)
	)
);
$related=$service->get_related_query($arg);
if(!$related or !$related->have_posts()) return FALSE;
?>
<div class="service-content-section">
	<h5 class="service-info-title"><?php echo esc_html__('Related ','wpbooing').$service_type; ?></h5>
	<div class="wpbooking-loop-wrap">
	<?php
	echo wpbooking_load_view('archive/loop',array('my_query'=>$related,'service_type'=>$service_type));
	 ?>
	</div>
</div>
<?php wp_reset_postdata();