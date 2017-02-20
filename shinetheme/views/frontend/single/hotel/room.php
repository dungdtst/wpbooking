<div class="service-content-section">
    <?php
    global $wp_query;
    $rooms=WPBooking_Accommodation_Service_Type::inst()->search_room();
    ?>
    <div class="search-room-availablity">
        <form method="post" name="form-search-room" class="form-search-room">
            <?php wp_nonce_field('room_search','room_search')?>
            <input name="action" value="ajax_search_room" type="hidden">
            <input name="hotel_id" value="<?php the_ID() ?>" type="hidden">
            <div class="search-room-form">
                <h5 class="service-info-title"><?php esc_html_e('Check availability', 'wpbooing') ?></h5>
                <div class="form-search">
                    <?php
                    $check_in = WPBooking_Input::request('checkin_y')."-".WPBooking_Input::request('checkin_m')."-".WPBooking_Input::request('checkin_d');
                    if($check_in == '--')$check_in='';else$check_in = date(get_option('date_format'),strtotime($check_in));
                    $check_out = WPBooking_Input::request('checkout_y')."-".WPBooking_Input::request('checkout_m')."-".WPBooking_Input::request('checkout_d');
                    if($check_out == '--')$check_out='';else$check_out = date(get_option('date_format'),strtotime($check_out));
                    ?>
                    <div class="form-item w20 form-item-icon">
                        <label><?php esc_html_e('Check In', 'wpbooing') ?><i class="fa fa-calendar"></i>
                            <input class="checkin_d" name="checkin_d" value="<?php echo esc_html(WPBooking_Input::request('checkin_d')) ?>" type="hidden">
                            <input class="checkin_m" name="checkin_m" value="<?php echo esc_html(WPBooking_Input::request('checkin_m')) ?>" type="hidden">
                            <input class="checkin_y" name="checkin_y" value="<?php echo esc_html(WPBooking_Input::request('checkin_y')) ?>" type="hidden">
                            <input type="text" readonly class="form-control wpbooking-search-start" value="<?php echo do_shortcode($check_in) ?>" name="check_in" placeholder="<?php esc_html_e('Check In', 'wpbooing') ?>">
                        </label>
                    </div>
                    <div class="form-item w20 form-item-icon">
                        <label><?php esc_html_e('Check Out', 'wpbooing') ?>
                            <input class="checkout_d" name="checkout_d" value="<?php echo esc_html(WPBooking_Input::request('checkout_d')) ?>" type="hidden">
                            <input class="checkout_m" name="checkout_m" value="<?php echo esc_html(WPBooking_Input::request('checkout_m')) ?>" type="hidden">
                            <input class="checkout_y" name="checkout_y" value="<?php echo esc_html(WPBooking_Input::request('checkout_y')) ?>" type="hidden">
                            <input type="text" readonly class="form-control wpbooking-search-end" value="<?php echo do_shortcode($check_out) ?>"  name="check_out" placeholder="<?php esc_html_e('Check Out', 'wpbooing') ?>">
                            <i class="fa fa-calendar"></i>
                        </label>
                    </div>
                    <div class="form-item w20">
                        <label><?php esc_html_e('Rooms', 'wpbooing') ?></label>
                        <select name="room_number" class="form-control">
                            <?php
                            for($i=1 ; $i<=20 ; $i++ ){
                                echo '<option value="'.esc_attr($i).'">'.esc_html($i).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-item w20">
                        <label><?php esc_html_e('Adults', 'wpbooing') ?></label>
                        <select name="adults" class="form-control">
                            <?php
                            for($i=1 ; $i<=20 ; $i++ ){
                                echo '<option value="'.esc_attr($i).'">'.esc_html($i).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-item w20">
                        <label><?php esc_html_e('Children', 'wpbooing') ?></label>
                        <select name="children" class="form-control">
                            <?php
                            for($i=0 ; $i<=20 ; $i++ ){
                                echo '<option value="'.esc_attr($i).'">'.esc_html($i).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-item w100">
                        <button type="button" class="wb-button btn-do-search-room"><?php esc_html_e("CHECK AVAILABILITY ","wpbooking") ?></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="search_room_alert"></div>
        <?php
        $is_have_post = '';
        if(!$rooms->have_posts()) {
            $is_have_post = 'have_none';
        }
        ?>
        <div class="content-search-room <?php echo esc_html($is_have_post) ?>">
            <?php
            $checkin_d = WPBooking_Input::request('checkin_d');
            $checkin_m = WPBooking_Input::request('checkin_m');
            $checkin_y = WPBooking_Input::request('checkin_y');

            $checkout_d = WPBooking_Input::request('checkout_d');
            $checkout_m = WPBooking_Input::request('checkout_m');
            $checkout_y = WPBooking_Input::request('checkout_y');

            $class = '';
            if(!$checkin_d and !$checkin_m and !$checkin_y and !$checkout_d and !$checkout_m and !$checkout_y){
                $class = 'no_date';
            }
            ?>
            <form method="post" class="wpbooking_order_form <?php echo esc_html($class) ?>">
                <input name="action" value="wpbooking_add_to_cart" type="hidden">
                <input name="post_id" value="<?php the_ID() ?>" type="hidden">
                <input name="wpbooking_checkin_d" class="form_book_checkin_d" value="<?php echo esc_attr($checkin_d) ?>"  type="hidden">
                <input name="wpbooking_checkin_m" class="form_book_checkin_m" value="<?php echo esc_attr($checkin_m) ?>" type="hidden">
                <input name="wpbooking_checkin_y" class="form_book_checkin_y" value="<?php echo esc_attr($checkin_y) ?>" type="hidden">

                <input name="wpbooking_checkout_d" class="form_book_checkout_d" value="<?php echo esc_attr($checkout_d) ?>" type="hidden">
                <input name="wpbooking_checkout_m" class="form_book_checkout_m" value="<?php echo esc_attr($checkout_m) ?>" type="hidden">
                <input name="wpbooking_checkout_y" class="form_book_checkout_y" value="<?php echo esc_attr($checkout_y) ?>" type="hidden">

                <input name="wpbooking_room_number" class="form_book_room_number"  type="hidden">
                <input name="wpbooking_adults" class="form_book_adults"  type="hidden">
                <input name="wpbooking_children" class="form_book_children"  type="hidden">
                <div class="content-loop-room">
                    <?php
                    $hotel_id = get_the_ID();
                    if($rooms->have_posts()) {
                        while( $rooms->have_posts() ) {
                            $rooms->the_post();
                            echo wpbooking_load_view('single/loop-room',array('hotel_id'=>$hotel_id));
                        }
                    }
                    ?>
                </div>
                <div class="content-info">
                    <div class="content-price">
                        <div class="number"><span class="info_number">0</span> <?php esc_html_e('room(s) selected','wpbooking') ?></div>
                        <div class="price"><span class="info_price">0</span></div>
                        <button type="button" class="wb-button submit-button"><?php esc_html_e("BOOK NOW",'wpbooking') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    wp_reset_postdata();

    ?>
</div>
