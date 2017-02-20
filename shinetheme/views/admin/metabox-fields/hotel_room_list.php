<?php
$old_data = esc_html($data['std']);
if (!empty($data['custom_name'])) {
    if (isset($data['custom_data'])) $old_data = $data['custom_data'];
} else {
    $old_data = get_post_meta($post_id, esc_html($data['id']), true);
}
if (!empty($value)) {
    $old_data = $value;
}
$class = ' wpbooking-form-group ';
$data_class = '';
if (!empty($data['condition'])) {
    $class .= ' wpbooking-condition ';
    $data_class .= ' data-condition=' . $data['condition'] . ' ';
}
$class .= ' width-' . $data['width'];
if (!empty($data['container_class'])) $class .= ' ' . $data['container_class'];

$field = '';
$name = isset($data['custom_name']) ? esc_html($data['custom_name']) : esc_html($data['id']);
$query = new WP_Query(array(
    'post_parent'    => $post_id,
    'posts_per_page' => 200,
    'post_type'=>'wpbooking_hotel_room'
));
if($query->found_posts < 1){
    $class .= ' wpbooking-no-room ';
}
?>
<div class="wpbooking-settings hotel_room_list <?php echo esc_html($class); ?>" <?php echo esc_html($data_class); ?>>
    <div class="st-metabox-content-wrapper">
        <div class="form-group">
            <h3 class="field-label"><?php echo esc_html($data['label']) ?></h3>
            <p class="field-desc"><?php echo esc_html($data['desc']) ?></p>
            <div class="wp-room-actions top">
                <div class="room-create top">
                    <a href="#" data-hotel-id="<?php echo esc_attr($post_id)?> " class="create-room"><?php esc_html_e('Create New Room','wpbooking') ?></a>
                </div>
            </div>
            <div class="wb-room-list">
                <?php
                while ($query->have_posts()){
                    $query->the_post();
                    $room_id = get_the_ID();
                    $image_id = '';
                    $gallery_list_room = get_post_meta(get_the_ID(),'gallery_room',true);
                    if(!empty($gallery_list_room)){
                        foreach($gallery_list_room as $k=>$v){
                            if(empty($image_id)){
                                $image_id = $v;
                            }
                        }
                    }
                    $thumbnail = wp_get_attachment_image($image_id,array(220,120));
                    ?>
                    <div class="room-item item-hotel-room-<?php echo esc_attr(get_the_ID()) ?>">
                        <div class="room-item-wrap">
                            <div class="thumbnail">

                            </div>
                            <div class="room-remain">
                                <?php $number = get_post_meta(get_the_ID(),'room_number',true);
                                if(empty($number))$number = 0;
                                ?>
                                <span class="room-remain-left"><?php printf(esc_html__('%d room(s)','wpbooking'),$number) ?></span>
                            </div>
                            <div class="room-image">
                                <?php echo do_shortcode($thumbnail) ?>
                            </div>
                            <h3 class="room-type"><?php the_title()?></h3>
                            <div class="room-actions">
                                <a href="#" data-room_id="<?php the_ID()?>" class="room-edit tooltip_desc"><i class="fa fa-pencil-square-o"></i> <span class="tooltip_content"><?php esc_html_e('Edit','wpbooking') ?></span></a>
                                <?php $del_security_post = wp_create_nonce('del_security_post_'.get_the_ID()); ?>
                                <a href="javascript:void(0)" data-room_id="<?php the_ID(); ?>" data-del-security="<?php echo esc_attr($del_security_post); ?>" data-confirm="<?php echo esc_html__('Do you want delete this room?','wpbooking'); ?>" class="room-delete tooltip_desc"><i class="fa fa-trash"></i><span class="tooltip_content"><?php esc_html_e('Delete','wpbooking') ?></span></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                ?>
            </div>
            <div class="wp-room-actions">
                <div class="room-create">
                    <a href="#" data-hotel-id="<?php echo esc_attr($post_id)?> " class="create-room"><?php esc_html_e('Create New Room','wpbooking') ?></a>
                </div>
                <?php echo do_shortcode(WPBooking_Accommodation_Service_Type::inst()->_get_room_count_text($post_id)); ?>
            </div>
            <div class="room-item-default hidden">
                <div class="room-item">
                    <div class="room-item-wrap">
                        <div class="room-remain">
                            <span class="room-remain-left"><?php printf(esc_html__('%d room(s)','wpbooking'),get_post_meta(get_the_ID(),'number',true)) ?></span>
                        </div>
                        <div class="room-image">
                        </div>
                        <h3 class="room-type"></h3>
                        <div class="room-actions">
                            <a href="#" data-room_id="<?php the_ID()?>" class="room-edit" data-edit-text="<?php echo esc_html__('Edit room','wpbooking')?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a href="javascript:void(0)" class="room-delete" data-confirm="<?php echo esc_html__('Do you want delete this room?','wpbooking'); ?>" ><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wb-no-room-message hidden">
                <span><?php echo esc_html__('There isn\'t room you listing'); ?> <a href="#" data-hotel-id="<?php echo esc_attr($post_id)?> " class="create-room"><?php esc_html_e('Create New Room','wpbooking') ?></a></span>
            </div>
        </div>
    </div>
</div>
<div class="wpbooking-hotel-room-form"></div>
<?php
wp_reset_postdata();
?>