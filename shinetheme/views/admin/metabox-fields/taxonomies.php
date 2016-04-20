<?php 
/**
*@since 1.0.0
**/


$class = ' traveler-form-group ';
$data_class = '';
if(!empty($data['condition'])){
    $class .= ' traveler-condition';
    $data_class .= ' data-condition='.$data['condition'].' ' ;
}
$name = isset( $data['custom_name'] ) ? esc_html( $data['custom_name'] ) : esc_html( $data['id'] );

$terms = get_object_taxonomies( 'traveler_service', 'objects' );

if( count( $terms ) ){
	unset( $terms['traveler_location'] );
}


?>
<div class="form-table traveler-settings <?php echo esc_html( $class ); ?>" <?php echo esc_html( $data_class ); ?>>
<div class="st-metabox-left">
	<label for="<?php echo esc_html( $data['id'] ); ?>"><?php echo esc_html( $data['label'] ); ?></label>
</div>
<div class="st-metabox-right">
	<div class="st-metabox-content-wrapper">
		<div class="form-group">
			<div class="traveler-list-taxonomies clearfix">
			<?php 
				if( !empty( $terms ) ):
					foreach( $terms as $key => $term ):
			?>	
				<h4><?php echo esc_html( $term->label ); ?></h4>
				<div class="traveler-list-taxonomy clearfix">
					
					<?php 

						$item_term = get_terms( $key , array(
							'hide_empty' => false
						) );

						if( !empty( $item_term ) ):

							$old = array();
							$old_terms = wp_get_post_terms( get_the_ID(), $key );
							if( !empty( $old_terms ) && is_array( $old_terms ) ){
								foreach( $old_terms as $term ){
									$old[] = (int) $term->term_id;
								}
							}

							foreach( $item_term as $item ):
					?>
						<div class="traveler-list-taxonomy-item">
							<label>
								<input <?php if( in_array( $item->term_id, $old ) ) echo 'checked'; ?> type="checkbox" value="<?php echo esc_html( $item->term_id ); ?>" name="<?php echo $name.'['. $key .'][]'; ?>">
								<span style="margin-left: 5px;"><strong><?php echo esc_html( $item->name ); ?></strong></span>
							</label>
						</div>
					<?php endforeach; endif; ?>
				</div>
			<?php endforeach; endif; ?>
			</div>
		</div>
	</div>
	<i class="traveler-desc"><?php echo balanceTags( $data['desc'] ) ?></i>
</div>
</div>