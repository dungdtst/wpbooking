<?php
$booking=WPBooking_Order::inst();
$extra_price=wpbooking_load_view('single/extra-price');
$form=$booking->get_order_form_by_post_id();
printf('<form onsubmit="return false" class="wpbooking_order_form">
			<input name="action" value="wpbooking_add_to_cart" type="hidden">
			<input name="post_id" value="%d" type="hidden">
		%s
		<br>
		%s
		</form>',get_the_ID(),$extra_price,$form);
