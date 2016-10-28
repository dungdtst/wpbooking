<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 4/4/2016
 * Time: 3:23 PM
 */
global $post;
if (post_password_required()) {
	echo get_the_password_form();
	return;
}
$service = new WB_Service();
$service_type=$service->get_type();
$hotel_id = get_the_ID();
?>
<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<meta itemprop="url" content="<?php the_permalink(); ?>"/>
	<div class="container-fluid wpbooking-single-content entry-header">
        <div class="wb-service-title-address">
            <h1 class="wb-service-title" itemprop="name"><?php the_title(); ?></h1>
            <div class="wb-hotel-star">
                <?php
                $service->get_star_rating_html();
                ?>
            </div>
            <?php $address = $service->get_address();
            if ($address) {
                ?>
                <div class="service-address">
                    <i class="fa fa-map-marker"></i> <?php echo esc_html($address) ?>
                </div>
            <?php } ?>
            <?php do_action('wpbooking_after_service_address_rate', get_the_ID(), $service->get_type(), $service) ?>
        </div>
        <div class="wb-price-html">
            <?php $service->get_price_html(true); ?>
        </div>
		<div class="row-service-gallery-contact">
			<div class="col-service-gallery">
				<div class="wb-tabs-gallery-map">
                    <ul class="wb-tabs">
                        <li class="active"><a href="#photos"><i class="fa fa-camera"></i> &nbsp;<?php esc_html_e('Photos','wpbooking'); ?></a></li>
                        <li ><a href="#map"><i class="fa fa-map-marker"></i> &nbsp;<?php esc_html_e('On the map','wpbooking'); ?></a></li>
                    </ul>
                    <div class="wp-tabs-content">
                        <div class="wp-tab-item" id="photos">
                            <div class="service-gallery-single">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                    <?php
                                    $gallery = $service->get_gallery();
                                    if(!empty($gallery) and is_array($gallery)){
                                        foreach($gallery as $k => $v){
                                            echo ($v['gallery']);
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="wp-tab-item" id="map">
                            <div class="service-map">
                                <?php
                                $map_lat = get_post_meta(get_the_ID(), 'map_lat', TRUE);
                                $map_lng = get_post_meta(get_the_ID(), 'map_long', TRUE);
                                $map_zoom = get_post_meta(get_the_ID(), 'map_zoom', TRUE);
                                if (!empty($map_lat) and !empty($map_lng)) { ?>
                                    <div class="service-map-element" data-lat="<?php echo esc_attr($map_lat) ?>"
                                         data-lng="<?php echo esc_attr($map_lng) ?>"
                                         data-zoom="<?php echo esc_attr($map_zoom) ?>"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="col-service-reviews-meta">
				<div class="wb-service-reviews-meta">
                    <?php
                    $review_score = WPBooking_Comment_Model::inst()->get_avg_review(get_the_ID());
                    $count = WPBooking_Comment_Model::inst()->count_parent(get_the_ID());
                    if($count > 0){
                    ?>
                   <div class="wb-reviews-score-box wp-box-item">
                        <?php

                        if($review_score > 4){
                            $str_rating = esc_html__('Excellent','wpbooking');
                        }elseif($review_score > 3){
                            $str_rating = esc_html__('Very Good','wpbooking');
                        }elseif($review_score > 2){
                            $str_rating = esc_html__('Average','wpbooking');
                        }elseif($review_score > 1){
                            $str_rating = esc_html__('Poor','wpbooking');
                        }else{
                            $str_rating = esc_html__('Terrible','wpbooking');
                        }

                        $wpbooking_review_stats=apply_filters('wpbooking_review_stats',array(),get_the_ID());

                        ?>
                       <div class="score-header">
                            <span class="reviews-count"><?php printf(_n('%s review','%s reviews',$count,'wpbooking'),$count); ?></span>
                           <span class="rating-str"><?php echo esc_attr($str_rating); ?></span>
                           <span class="review-score"><?php echo number_format($review_score,1,'.',''); ?></span> <span class="max-rating"><?php echo esc_html__('of 5 guest rating');?></span>
                       </div>
                       <?php if($wpbooking_review_stats){ ?>
                       <ul class="list_review_fields">
                           <?php foreach($wpbooking_review_stats as $key => $value) {
                               $rating_score = $service->get_avg_rating($value['title']);
                               if ($rating_score) {
                                   ?>
                                   <li>
                                       <span class="rating_title"><?php echo esc_attr($value['title']); ?>&nbsp;</span>
                                       <span class="rating">
                                   <span class="<?php if ($rating_score >= 0.5) echo 'active'; ?>"><i
                                           class="fa fa-star-o icon-star"></i></span>
                                   <span class="<?php if ($rating_score >= 1.5) echo 'active'; ?>"><i
                                           class="fa fa-star-o icon-star"></i></span>
                                   <span class="<?php if ($rating_score >= 2.5) echo 'active'; ?>"><i
                                           class="fa fa-star-o icon-star"></i></span>
                                   <span class="<?php if ($rating_score >= 3.5) echo 'active'; ?>"><i
                                           class="fa fa-star-o icon-star"></i></span>
                                   <span class="<?php if ($rating_score >= 4.5) echo 'active'; ?>"><i
                                           class="fa fa-star-o icon-star"></i></span>
                               </span>
                                   </li>
                               <?php }
                           }?>
                       </ul>
                       <?php } ?>
                   </div>
                    <?php } ?>
                        <?php
                        $contact_meta = array(
                            'contact_number' => 'fa-phone',
                            'contact_email' => 'fa-envelope',
                            'website' => 'fa-home',
                        );
                        $html = '';
                        foreach($contact_meta as $key => $val) {
                            if ($value = get_post_meta(get_the_ID(), $key, true)) {
                                switch($key){
                                    case 'contact_number':
                                    case 'contact_email':
                                        $value = ($value);
                                        break;
                                    case 'website';
                                        $value = '<a href="'.$value.'">'.$value.'</a>';
                                        break;
                                }
                                $html .= '<div class="wb-meta-contact">
                                    <i class="fa '.$val.' wb-icon-contact"></i>
                                    <span>'.$value.'</span>
                                </div>';
                            }
                        }
                        if(!empty($html)){
                            echo '<div class="wb-contact-box wp-box-item">'.$html.'</div>';
                        }
                        ?>
                    <div class="wb-share">
                        <div class="wb-button-share">
                            <i class="fa fa-share-alt"></i><a href="#"><?php esc_html_e('Share','wpbooking'); ?></a>
                        </div>
                        <ul class="wb-list-social">
                            <li><a class="wb-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title()?>" target="_blank" original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="wb-twitter" href="http://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title()?>" target="_blank" original-title="Twitter"><i class="fa fa-twitter fa-lg"></i></a></li>
                            <li><a class="wb-google" href="https://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title()?>" target="_blank" original-title="Google+"><i class="fa fa-google-plus fa-lg"></i></a></li>
                            <li><a class="wb-pinterest" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" target="_blank" original-title="Pinterest"><i class="fa fa-pinterest fa-lg"></i></a></li>
                            <li><a class="wb-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title()?>" target="_blank" original-title="LinkedIn"><i class="fa fa-linkedin fa-lg"></i></a></li>
                        </ul>
                    </div>
				</div>
			</div>
		</div>
		<div class="service-content-section">
			<h5 class="service-info-title"><?php esc_html_e('Description', 'wpbooing') ?></h5>

			<div class="service-content-wrap">
				<?php
				if (have_posts()) {
					while (have_posts()) {
						the_post();
						the_content();
					}
				}
				?>
			</div>
		</div>
        <?php
        $amenities = get_post_meta(get_the_ID(),'wpbooking_select_amenity',true);
        if(!empty($amenities)){
        ?>
        <div class="service-content-section">
            <h5 class="service-info-title"><?php esc_html_e('Amenities', 'wpbooing') ?></h5>

            <div class="service-content-wrap">
                <ul class="wb-list-amenities">
                <?php
                foreach($amenities as $val){
                    $amenity = get_term_by('id',$val,'wpbooking_amenity');
                    if(!empty($amenity)){
                        echo '<li><i class="fa fa-check-square-o"></i> &nbsp;'.$amenity->name.'</li>';
                    }
                }
                ?>
                </ul>
            </div>
        </div>
        <?php } ?>
		<div class="service-content-section">

				<div class="search-room-availablity">
					<form method="post" name="form-search-room" class="form-search-room">
						<?php wp_nonce_field('room_search','room_search')?>
						<input name="action" value="ajax_search_room" type="hidden">
						<div class="search-room-form">
							<h5 class="service-info-title"><?php esc_html_e('Check availablity', 'wpbooing') ?></h5>
							<div class="form-search">
								<div class="form-item w20 form-item-icon">
									<label><?php esc_html_e('Check In', 'wpbooing') ?></label>
									<input class="form-control wpbooking-search-start" name="check_in" placeholder="<?php esc_html_e('Check In', 'wpbooing') ?>">
									<i class="fa fa-calendar"></i>
								</div>
								<div class="form-item w20 form-item-icon">
									<label><?php esc_html_e('Check Out', 'wpbooing') ?></label>
									<input class="form-control wpbooking-search-end" name="check_out" placeholder="<?php esc_html_e('Check Out', 'wpbooing') ?>">
									<i class="fa fa-calendar"></i>
								</div>
								<div class="form-item w20">
									<label><?php esc_html_e('Rooms', 'wpbooing') ?></label>
									<select name="room_number" class="form-control">
										<?php
										for($i=1 ; $i<=20 ; $i++ ){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
								<div class="form-item w20">
									<label><?php esc_html_e('Adults', 'wpbooing') ?></label>
									<select name="adults" class="form-control">
										<?php
										for($i=1 ; $i<=20 ; $i++ ){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
								<div class="form-item w20">
									<label><?php esc_html_e('Children', 'wpbooing') ?></label>
									<select name="children" class="form-control">
										<?php
										for($i=0 ; $i<=20 ; $i++ ){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
								<button type="button" class="wb-button btn-do-search-room"><?php esc_html_e("CHECK AVAILABLITY","wpbooking") ?></button>
                                <img class="img_loading" src="<?php echo admin_url('/images/wpspin_light.gif') ?>">
							</div>
						</div>
					</form>
					<div class="search_room_alert"></div>
					<div class="content-search-room">
						<form method="post" class="wpbooking_order_form">
							<input name="action" value="wpbooking_add_to_cart" type="hidden">
							<input name="post_id" value="<?php the_ID() ?>" type="hidden">
							<div class="content-loop-room">
								<?php
								global $wp_query;
								WPBooking_Accommodation_Service_Type::inst()->search_room();
								?>
								<?php
								if(have_posts()) {
									while( have_posts() ) {
										the_post();
										echo wpbooking_load_view('single/loop-room',array('hotel_id'=>$hotel_id));
									}
								} else {
									echo wpbooking_load_view('single/loop-room-none');
								}
								?>
								<?php wp_reset_query(); ?>
							</div>
							<div class="content-info">
								<div class="content-price">
									<div class="number"><span class="info_number">0</span> <?php esc_html_e('rooms selected','wpbooking') ?></div>
									<div class="price"><span class="info_price">0</span></div>
									<button type="button" class="wb-button submit-button"><?php esc_html_e("BOOK NOW",'wpbooking') ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>

		</div>
		<div class="service-content-section">
			<h5 class="service-info-title"><?php esc_html_e('Accommodation Policies', 'wpbooing') ?></h5>

			<div class="service-details">
                <?php
                $check_in = array(
                    'checkin_from'  => esc_html__('from %s ', 'wpbooking'),
                    'checkin_to' => esc_html__('to %s', 'wpbooking')
                );
                $check_out = array(
                    'checkout_from'  => esc_html__('from %s ', 'wpbooking'),
                    'checkout_to' => esc_html__('to %s', 'wpbooking')
                );
                $time_html = '';
                $checkin_html = esc_html__('Check In: ','wpbooking');
                $checkout_html = esc_html__('Check Out: ','wpbooking');
                foreach ($check_in as $key => $val) {
                    $value = get_post_meta(get_the_ID(),$key ,TRUE);
                    if($key == 'checkin_from' && empty($value)){
                        $checkin_html = '';
                        break;
                    }else{
                        if(!empty($value)) {
                            $checkin_html .= sprintf($val, $value);
                        }
                        if($key == 'checkin_to' && empty($value)){
                            $checkin_html = str_replace('from ','',$checkin_html);
                        }
                    }
                }
                $bool = false;
                foreach ($check_out as $key => $val) {
                    $value = get_post_meta(get_the_ID(),$key ,TRUE);
                    if($key == 'checkout_to' && empty($value)){
                        $checkout_html = '';
                        break;
                    }else{
                        if(!empty($value)) {
                            $checkout_html .= sprintf($val, $value);
                            if($bool) $checkout_html = $value;
                        }
                        if($key == 'checkout_from' && empty($value)){
                            $bool = true;
                        }
                    }
                }
                $time_html = $checkin_html.'<br>'.$checkout_html;
                if(!empty($checkin_html) || !empty($checkout_html)) {
                    ?>
                    <div class="service-detail-item">
                        <div class="service-detail-title"><?php esc_html_e('Time', 'wpbooking') ?></div>
                        <div class="service-detail-content">
                            <?php echo ($time_html) ?>
                        </div>
                    </div>
                    <?php
                }
				$array = array(
					'deposit_payment_status' => '',
                    'deposit_payment_amount' => wp_kses(__('Deposit : %s &nbsp;&nbsp;<span class="enforced_red">required</span>','wpbooking'),array('span'=>array('class'=>array()))),
                    'allow_cancel' => esc_html__('Cancelation allowed : Yes','wpbboking'),
                    'cancel_free_days_prior' => esc_html__('Time allowed to free : %s','wpbooking'),
                    'cancel_guest_payment' => esc_html__('Fee cancel booking : %s','wpbooking'),
				);
                $cancel_guest_payment = array(
                    'first_night' => esc_html__('of the first night','wpbooking'),
                    'full_stay' => esc_html__('of the full stay','wpbooking'),
                );
				$deposit_html = array();
                $allow_deposit = '';
				foreach ($array as $key => $val) {
                    $meta = get_post_meta(get_the_ID(), $key, TRUE);
                    if($key == 'deposit_payment_status'){
                        $allow_deposit = $meta;
                        continue;
                    }
					if (!empty($meta)) {
                        if($key == 'deposit_payment_amount') {
                            if(empty($allow_deposit)) {
                                $deposit_html[] = '';
                            }elseif($allow_deposit == 'amount'){
                                $deposit_html[] = sprintf($val, WPBooking_Currency::format_money($meta));
                            }else{
                                $deposit_html[] = sprintf($val, $meta.'%');
                            }
                            continue;
                        }
                        if($key == 'cancel_guest_payment'){
                            $deposit_html[] = sprintf($val, $cancel_guest_payment[$meta]);
                            continue;
                        }
                        $deposit_html[] = sprintf($val, $meta);
					}
                    if($key == 'allow_cancel'){
                        $deposit_html[] = $val;
                        continue;
                    }
				}

				if (!empty($deposit_html)) {
					?>
					<div class="service-detail-item">
						<div class="service-detail-title"><?php esc_html_e('Prepayment / cancelation', 'wpbooking') ?></div>
						<div class="service-detail-content">
							<?php
                            foreach($deposit_html as $value){
                                if(!empty($value)) echo ($value).'<br>';
                            }
                            ?>
						</div>
					</div>
				<?php } ?>


				<?php
						$tax_html=array();
						$array = array(
							'vat_excluded'          => '',
							'vat_amount' => esc_html__('V.A.T: %s &nbsp;&nbsp;'),
							'citytax_excluded' => '',
                            'citytax_unit' => '',
							'citytax_amount' => esc_html__('City tax: %s '),
						);
                $citytax_unit = array(
                    'stay' => esc_html__('stay','wpbooking'),
                    'person_per_stay' => esc_html__('person per stay','wpbooking'),
                    'night' => esc_html__('night','wpbooking'),
                    'percent' => esc_html__('percent(%)','wpbooking'),
                    'person_per_night' => esc_html__('person per night','wpbooking'),
                );
                $vat_excluded = '';
                $citytax_excluded = '';
                $ct_unit= '';
						foreach ($array as $key => $val) {
                            $value = get_post_meta(get_the_ID(), $key, TRUE);
							if (!empty($value)) {
                                switch($key){
                                    case 'vat_excluded':
                                        $vat_excluded = $value;
                                        break;
                                    case 'vat_amount':
                                        if($vat_excluded == 'yes_included'){
                                            $tax_html[] = sprintf($val, $value.'% &nbsp;&nbsp;'.wp_kses(__('<span class="enforced_red">include</span>','wpbooking'),array('span' => array('class' => array()))));
                                        }elseif($vat_excluded != 'no'){
                                            $tax_html[] = sprintf($val, $value.'%');
                                        }
                                        break;
                                    case 'citytax_excluded':
                                        $citytax_excluded = $value;
                                        break;
                                    case 'citytax_unit':
                                        $ct_unit = $value;
                                        break;
                                    case 'citytax_amount':
                                        if(!empty($ct_unit)) {
                                            if ($ct_unit == 'percent') {
                                                $str_citytax = sprintf($val, $value) . $citytax_unit[$ct_unit];
                                            } else {
                                                $str_citytax = sprintf($val, WPBooking_Currency::format_money($value)) . $citytax_unit[$ct_unit];
                                            }
                                        }
                                        if($citytax_excluded != 'no') {
                                            if ($citytax_excluded == 'yes_included') {
                                                $tax_html[] = $str_citytax . '&nbsp;&nbsp; <span class="enforced_red">' . esc_html__('include', 'wpbooking') . '</span>';
                                            } else {
                                                $tax_html[] = $str_citytax;
                                            }
                                        }
                                        break;
                                }
							}
						}

						if(!empty($tax_html)){
							?>
							<div class="service-detail-item">
								<div
									class="service-detail-title"><?php esc_html_e('Tax', 'wpbooking') ?></div>
								<div class="service-detail-content">
									<?php foreach($tax_html as $value){
                                        echo ($value).'<br>';
                                    }?>
								</div>
							</div>
						<?php }  ?>



				<?php
				if ($terms_conditions = get_post_meta(get_the_ID(),'terms_conditions',true)) { ?>
					<div class="service-detail-item">
						<div class="service-detail-title"><?php esc_html_e('Term & Condition', 'wpbooking') ?></div>
						<div class="service-detail-content">
							<?php echo ($terms_conditions); ?>
						</div>
					</div>
				<?php } ?>

				<?php
                $card = get_post_meta(get_the_ID(),'creditcard_accepted',true);
                $card_image = array(
                    'americanexpress' => '0 -145px',
                    'visa' => '0 1px',
                    'euromastercard' => '0 -24px',
                    'dinersclub' => '0 -96px',
                    'jcb' => '0 -121px',
                    'maestro' => '0 -48px',
                    'discover' => '0 -73px',
                    'unionpaydebitcard' => '0 -194px',
                    'unionpaycreditcard' => '0 -194px',
                    'bankcard' => '0 -584px',
                );
                if(!empty($card)) {
                ?>
				<div class="service-detail-item">
					<div class="service-detail-title"><?php esc_html_e('Cart Accepted', 'wpbooking') ?></div>
					<div class="service-detail-content">
                        <ul class="wb-list-card-acd">
                            <?php foreach($card as $key => $val){
                                if(!empty($val)){
                                    echo '<li style="background-position: '.$card_image[$key].'">';
                                    echo '</li>';
                                }
                            }?>
                        </ul>
					</div>
				</div>
                <?php } ?>

			</div>
		</div>

		<div class="service-content-section comment-section">
			<?php
			if (comments_open(get_the_ID()) || get_comments_number()) :
				comments_template();
			endif;
			?>
		</div>
		<?php echo wpbooking_load_view('single/related') ?>

	</div>
</div>
