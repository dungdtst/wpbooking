<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 1/6/2017
 * Version: 1.0
 */

$url = add_query_arg(array(
    'checkin_d'  => WPBooking_Input::get('checkin_d'),
    'checkin_m'  => WPBooking_Input::get('checkin_m'),
    'checkin_y'  => WPBooking_Input::get('checkin_y'),
    'checkout_d' => WPBooking_Input::get('checkout_d'),
    'checkout_m' => WPBooking_Input::get('checkout_m'),
    'checkout_y' => WPBooking_Input::get('checkout_y'),
    'adult'     => WPBooking_Input::get('adult_s'),
    'child'     => WPBooking_Input::get('child_s'),
), get_permalink());
$service = new WB_Service();
?>
<li <?php post_class('loop-item') ?>>
    <div class="content-item">
        <?php
        $thumb_bg = WPBooking_Assets::build_css_class('background: url('.$service->get_featured_image('thumb_url').') ; background-size: cover; background-position: center');
        ?>
        <?php
        if(wpbooking_get_layout_archive() == 'grid'){
            ?>
            <div class="service-thumbnail">
                <?php
                echo do_shortcode($service->get_featured_image('thumb'));
                ?>
            </div>
        <?php
        }else{
            ?>
            <div class="service-thumbnail <?php echo esc_attr($thumb_bg); ?>"></div>
            <?php
        }
        ?>

        <div class="service-content">
            <div class="service-content-inner">
                <h3 class="service-title"><a
                        href="<?php echo esc_url($url) ?>"><strong><?php the_title() ?></strong></a></h3>

                <div class="service-address-rate">
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
                </div>
                <?php do_action('wpbooking_after_service_address', get_the_ID(), $service->get_type(), $service) ?>
            </div>
            <div class="service-price-book-now">
                <div class="service-price">
                    <?php
                    $service->get_price_html();
                    ?>
                </div>
                <div class="service-book-now">
                    <a class="wb-btn wb-btn-default wb-btn-sm"
                       href="<?php echo esc_url($url) ?>"><?php esc_html_e('Book Now', 'wpbooking') ?></a>
                </div>
            </div>
        </div>
    </div>
</li>
