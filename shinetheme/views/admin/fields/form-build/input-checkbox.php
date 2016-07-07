<?php
$class = "wpbooking-col-md-6";
if(!empty($data['edit_field_class'])){
    $class = $data['edit_field_class'];
}
?>
<div class="<?php echo esc_html($class) ?> ">
    <div class="wpbooking-build-group ">
		<?php if(!empty($data['title'])){?>
        <label class="control-label"><?php echo balanceTags($data['title']) ?>:</label>
		<?php } ?>
        <div class="wpbooking-row group-checkbox">
            <?php if(!empty($data['options'])){
                foreach($data['options'] as $k=>$v){
					$class=FALSE;
					if(!empty($data['single_checkbox'])) $class='single_checkbox';

                    echo ' <div class="wpbooking-col-md-12"><label><input type="checkbox"  class="item_check_box '.$class.'" value="'.$v.'">'.$k.'</label></div>';
                }
            } ?>
        </div>
        <input type="hidden" data-type="checkbox"  class="item" data-name-shortcode="<?php echo esc_attr($parent) ?>" name="<?php echo balanceTags($data['name']) ?>" id="<?php echo balanceTags($data['name']) ?>">
        <i class="desc"><?php echo esc_html($data['desc'])  ?></i>
    </div>
</div>