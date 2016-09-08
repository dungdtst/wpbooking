<?php
global $current_user;
$user_id = WPBooking_Input::request('user_id',get_the_author_meta( 'ID' ));

    global $wpdb;
    $sql = "
    SELECT SQL_CALC_FOUND_ROWS *
    FROM
        {$wpdb->prefix}posts
    INNER JOIN {$wpdb->prefix}wpbooking_favorite ON {$wpdb->prefix}posts.ID = {$wpdb->prefix}wpbooking_favorite.post_id
    WHERE
        1 = 1
        AND {$wpdb->prefix}wpbooking_favorite.user_id = {$user_id}
    ORDER BY
        {$wpdb->prefix}posts.ID DESC
    ";
    $res = $wpdb->get_results($sql);
    $total_item=$wpdb->get_var('SELECT FOUND_ROWS()');

$args = array(
    'posts_per_page' => 10,
    'post_type'      => 'wpbooking_service',
    'paged'          => WPBooking_Input::get('page_number',1),
    'author'         => get_current_user_id()

);
if ($service_type = WPBooking_Input::get('service_type')) {
    $args['meta_key'] = 'service_type';
    $args['meta_value'] = $service_type;
}
$query = new WP_Query($args);
var_dump($query->request);

$types = WPBooking_Service_Controller::inst()->get_service_types();
?>
<h3 class="tab-page-title">
    <?php
    echo esc_html__('Your Wishlist', 'wpbooking');
    ?>
</h3>
<?php if (!empty($types) and count($types) > 1) { ?>
    <ul class="service-filters">
        <?php
        $class = FALSE;
        if (!WPBooking_Input::get('service_type')) $class = 'active';
        foreach ($types as $type_id => $type) {
            $class = FALSE;
            if(WPBooking_Input::get('service_type')==$type_id) $class='active';
            $url = esc_url(add_query_arg(array('service_type' => $type_id), get_permalink(wpbooking_get_option('myaccount-page')).'tab/your_wishlist'));
            printf('<li class="%s"><a href="%s">%s</a></li>', $class, $url, $type->get_info('label'));
        }
        ?>
    </ul>
<?php } ?>
<div class="wpbooking-account-services">
    <?php if ($query->have_posts()) {
        $title = sprintf('You have %d service(s)',$query->found_posts);
        if($service_type and $service_type_object=WPBooking_Service_Controller::inst()->get_service_type($service_type)){
            $title=sprintf('You have %d %s(s)',$query->found_posts,strtolower($service_type_object->get_info('label')));
        }

        while($query->have_posts()){
            $query->the_post();
            $service=new WB_Service();
            ?>
            <div class="service-item">
                <div class="service-img">
                    <?php echo ($service->get_featured_image('thumb')) ?>
                </div>
                <div class="service-info">
                    <h5 class="service-title">
                        <a href="<?php the_permalink()?>" target="_blank"><?php the_title()?></a>
                    </h5>
                    <p class="service-price"><?php $service->get_price_html(TRUE) ?></p>
                    <div class="service-status">
                        <a href="#" data-post="<?php the_ID() ?>"
                           class="service-fav <?php if ($service->check_favorite()) echo 'active'; ?>"><i
                                class="fa fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        printf('<div class="alert alert-danger">%s</div>', esc_html__('No Service(s) Found', 'wpbooking'));
    }


    ?>
    <div class="wpbooking-pagination">
        <?php  echo paginate_links(array(
            'total'=>$query->max_num_pages,
            'current'  => WPBooking_Input::get('page_number', 1),
            'format'   => '?page_number=%#%',
            'add_args' => array()
        ));?>
    </div>

</div>
<?php wp_reset_postdata(); ?>


<h3 class="tab-page-title">
    <?php esc_html_e("You Wishlist",'wpbooking') ?>
</h3>
<div class="container-fluid">
    <?php
    global $wpdb;
    $sql = "
    SELECT SQL_CALC_FOUND_ROWS *
    FROM
        {$wpdb->prefix}posts
    INNER JOIN {$wpdb->prefix}wpbooking_favorite ON {$wpdb->prefix}posts.ID = {$wpdb->prefix}wpbooking_favorite.post_id
    WHERE
        1 = 1
        AND {$wpdb->prefix}wpbooking_favorite.user_id = {$user_id}
    ORDER BY
        {$wpdb->prefix}posts.ID DESC
    ";
    $res = $wpdb->get_results($sql);
    $total_item=$wpdb->get_var('SELECT FOUND_ROWS()');
    ?>
    <div class="row ">
        <div class="col-md-12">
            <div class="tab_wishlist">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-all" data-toggle="tab"><?php _e("Room","wpbooking") ?></a></li>
                    <li><a href="#tab-all" data-toggle="tab"><?php _e("Rental","wpbooking") ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-all">
                        <div class="dark_bg">
                            <div class="lable">
                                You are wishing 60 rooms
                            </div>
                            <div class="content-item">

                                <div class="item">
                                    <div class="image"></div>
                                    <div class="content"></div>
                                    <div class="control">
                                        <a class="service-fav " data-post="4" href="#"><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

