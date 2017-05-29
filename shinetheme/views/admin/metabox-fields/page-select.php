<?php
/**
 *@since 1.0.0
 **/
$data=wp_parse_args($data,array(
    'placeholder'=>false
));
$old_data = esc_html( $data['std'] );

if(!empty($data['custom_name'])){
    if(isset($data['custom_data'])) $old_data=$data['custom_data'];
}else{
    $meta_data = get_post_meta( $post_id, esc_html( $data['id'] ), true);
    if(!empty($meta_data)){
        $old_data = $meta_data;
    }
}
if( !empty( $value ) ){
    $old_data = $value;
}

$class = ' wpbooking-form-group ';
$data_class = '';
if(!empty($data['condition'])){
    $class .= ' wpbooking-condition ';
    $data_class .= ' data-condition='.$data['condition'].' ' ;
}
$class.=' width-'.$data['width'];
if(!empty($data['container_class'])) $class.=' '.$data['container_class'];

$name = isset( $data['custom_name'] ) ? esc_html( $data['custom_name'] ) : esc_html( $data['id'] );

$my_posts = get_posts( array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ) );

?>

<div class="wpbooking-settings <?php echo esc_html( $class ); ?>" <?php echo esc_html( $data_class ); ?>>
    <div class="st-metabox-left">
        <label for="<?php echo esc_html( $data['id'] ); ?>"><?php echo esc_html( $data['label'] ); ?></label>
    </div>
    <div class="st-metabox-right">
        <div class="st-metabox-content-wrapper">
            <div class="form-group">
                <?php if(!empty($my_posts)){ ?>
                    <select id="<?php echo esc_attr($data['id']) ?>" class="form-control  small" name="<?php echo esc_html($name) ?>">
                        <?php echo '<option value="">-- ' . esc_html__( 'Choose One', 'wpbooking' ) . ' --</option>'; ?>
                        <?php foreach($my_posts as $k=>$v){ ?>
                            <option <?php if($old_data == $v->ID) echo "selected"; ?> value="<?php echo esc_attr($v->ID) ?>"><?php echo esc_html($v->post_title) ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
                <?php
                if(!empty($data['tooltip_desc'])){
                    printf('<div class="tooltip_desc" ><i class="fa fa-question-circle"></i><span class="tooltip_content">%s</span></div>',$data['tooltip_desc']);
                }
                if(!empty($data['help_inline'])){
                    printf('<span class="help_inline">%s</span>',$data['help_inline']);
                }
                ?>
            </div>
        </div>
        <div class="metabox-help"><?php echo do_shortcode( $data['desc'] ) ?></div>
    </div>
</div>