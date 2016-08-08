<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 3/14/2016
 * Time: 9:32 AM
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('WPBooking_Service_Controller')) {
	class WPBooking_Service_Controller extends WPBooking_Controller
	{

		private static $_inst;

		function __construct()
		{
			// Load Abstract Service Type class and Default Service Types

			$loader = WPBooking_Loader::inst();
			$loader->load_library(array(
				'service-types/abstract-service-type',
				'service-types/room',
			));

			//add_filter('comment_form_field_comment', array($this, 'add_review_field'));
			add_action('comment_post', array($this, '_save_review_stats'));
			//add_filter('get_comment_text', array($this, '_show_review_stats'), 100);

			add_filter('template_include', array($this, '_show_single_service'));

			// archive page
			add_filter('template_include', array($this, 'template_loader'));
			add_filter('body_class', array($this, '_add_body_class'));

			/**
			 *
			 * Ajax Get Calendar Months
			 * @author dungdt
			 * @since 1.0
			 */
			add_action('wp_ajax_wpbooking_calendar_months', array($this, '_calendar_months'));
			add_action('wp_ajax_nopriv_wpbooking_calendar_months', array($this, '_calendar_months'));

			/**
			 * Ajax Filter
			 * @author dungdt
			 * @since 1.0
			 */
			add_action('template_redirect', array($this, '_ajax_filter_archivepage'), 100);

			/**
			 * Ajax Add Favorite
			 * @author dungdt
			 * @since 1.0
			 */
			add_action('wp_ajax_wpbooking_add_favorite', array($this, '_add_favorite'));

			/**
			 * Filter to load specific comment template file
			 *
			 * @since 1.0
			 * @author dungdt
			 */
			add_filter('comments_template', array($this, '_comments_template'));

			/**
			 * Ajax Vote Review Handler
			 *
			 * @since 1.0
			 * @author dungdt
			 */
			add_action('wp_ajax_wpbooking_vote_review', array($this, '_wpbooking_vote_review'));

			/**
			 * Ajax Reply a Review
			 *
			 * @since 1.0
			 * @author dungdt
			 */
			add_action('wp_ajax_wpbooking_write_reply', array($this, '_wpbooking_write_reply'));
		}

		/**
		 * Ajax Callback Add Favorite
		 *
		 * @since 1.0
		 * @author dungdt
		 */
		function _add_favorite()
		{
			$res = array('status' => 0);

			if (is_user_logged_in()) {
				if (!$post_id = WPBooking_Input::post('post_id')) {
					$res['message'] = esc_html__('Post ID is required', 'wpbooking');
				} else {
					$service = new WB_Service($post_id);
					$res['status'] = 1;
					$res['fav_status'] = $service->do_favorite();
				}
			} else {
				$res['not_logged_in'] = 1;
				$res['login_url'] = wp_login_url();
			}

			echo json_encode($res);
			die;
		}

		/**
		 * Ajax Filter Service Type
		 *
		 * @author dungdt
		 * @since 1.0
		 *
		 */
		function _ajax_filter_archivepage()
		{

			// Ajax Search Handle
			if (WPBooking_Helpers::is_ajax() and WPBooking_Input::get('wpbooking_action') == 'archive_filter') {
				if (get_query_var('paged')) {
					$paged = get_query_var('paged');
				} else if (get_query_var('page')) {
					$paged = get_query_var('page');
				} else {
					$paged = 1;
				}
				$args = array(
					'post_type'      => 'wpbooking_service',
					's'              => '',
					'paged'          => $paged,
					'posts_per_page' => 3,
				);
				$service_type = '';
				$is_page = get_the_ID();
				$list_page_search = apply_filters("wpbooking_add_page_archive_search", array());
				if (!empty($list_page_search[$is_page])) {
					$service_type = $list_page_search[$is_page];
				}
				$my_query = $this->query($args, $service_type);

				$res = array(
					'html' => wpbooking_load_view('archive/loop', array('my_query' => $my_query, 'service_type' => $service_type)),
				);
				$res['html'] .= wpbooking_load_view('archive/pagination', array('my_query' => $my_query, 'service_type' => $service_type));

				$res['updated_element'] = array(
					'.post-query-desc' => wpbooking_post_query_desc(WPBooking_Input::post())
				);

				echo json_encode($res);
				die;

			}
		}

		/**
		 * Function Ajax Get Calendar Months
		 * @since 1.0
		 * @return string json result
		 */
		function _calendar_months()
		{
			$res = array();

			$post_id = WPBooking_Input::post('post_id');
			$currentMonth = WPBooking_Input::post('currentMonth');
			$currentYear = WPBooking_Input::post('currentYear');
			$start_date = new DateTime($currentYear . '-' . $currentMonth . '-1');
			$start = $start_date->getTimestamp();
			$end_date = $start_date->modify('+3 months');
			$end = $end_date->getTimestamp();

			$raw_data = WPBooking_Calendar_Model::inst()->calendar_months($post_id, $start, $end);
			$calendar_months = array();

			// Default Months
			for ($i = 0; $i < 3; $i++) {
				$date = new DateTime($currentYear . '-' . $currentMonth . '-1');
				if (!$i) {
					$calendar_months[$date->format('m_Y')] = array();
				} else {
					$date->modify('+' . $i . ' months');
					$calendar_months[$date->format('m_Y')] = array();
				}
			}

			if (!empty($raw_data)) {
				foreach ($raw_data as $k => $v) {
					// Ignore Not Available Date
					if ($v['status'] == 'not_available') continue;

					$key = date('m', $v['start']) . '_' . date('Y', $v['start']);
					$calendar_months[$key][] = array(
						'date'            => date('Y-m-d', $v['start']),
						'price'           => WPBooking_Currency::format_money($v['price']),
						'tooltip_content' => sprintf(esc_html__('%s - %d available', 'wpbooking'), WPBooking_Currency::format_money($v['price']), $v['number'] - $v['total_booked'])
					);
				}
			}

			$res['months'] = $calendar_months;

			echo json_encode($res);

			die;
		}

		function _add_body_class($class)
		{
			if (is_singular()) {
				$is_page = get_the_ID();
				$list_page_search = apply_filters("wpbooking_add_page_archive_search", array());
				if (!empty($list_page_search[$is_page])) {
					$class[] = 'wpbooking-archive-page';
				}
			}

			return $class;
		}

		function query($args = array(), $service_type = FALSE)
		{
			$args = wp_parse_args($args, array(
				'post_type' => 'wpbooking_service'
			));

			$args = apply_filters('wpbooking_service_query_args', $args);
			$args = apply_filters('wpbooking_service_query_args_' . $service_type, $args);

			do_action('wpbooking_before_service_query', $args);
			do_action('wpbooking_before_service_query_' . $service_type, $args);

			$query = new WP_Query($args);

			do_action('wpbooking_after_service_query', $args);
			do_action('wpbooking_after_service_query_' . $service_type, $args);

			return $query;
		}

		/**
		 * @param $template
		 * @return string
		 */
		public function template_loader($template)
		{
			$is_page = get_the_ID();
			$list_page_search = apply_filters("wpbooking_add_page_archive_search", array());
			if (!empty($list_page_search[$is_page])) {
				$template = wpbooking_view_path('archive-service');


			}

			return $template;
		}

		/**
		 * @return array|mixed|void
		 */
		function _get_list_field_search()
		{
			$taxonomy = get_object_taxonomies('wpbooking_service', 'array');
			$list_taxonomy = array();
			if (!empty($taxonomy)) {
				foreach ($taxonomy as $k => $v) {
					if ($k == 'wpbooking_location') continue;
					$list_taxonomy[$k] = $v->label;
				}
			}
			$list_filed = array(
				'room' => array(
					array(
						'name'    => 'field_type',
						'label'   => __('Field Type', "wpbooking"),
						'type'    => "dropdown",
						'options' => array(
							"location_id"         => __("Location Dropdown", "wpbooking"),
							"location_suggestion" => __("Location Suggestion", "wpbooking"),
							"check_in"            => __("Check In", "wpbooking"),
							"check_out"           => __("Check Out", "wpbooking"),
							"taxonomy"            => __("Taxonomy", "wpbooking"),
							"review_rate"         => __("Review Rate", "wpbooking"),
							"price"               => __("Price", "wpbooking"),
							"bed"                 => __("Beds", "wpbooking"),
							"bedroom"             => __("Bedrooms", "wpbooking"),
							"bathroom"            => __("Bathrooms", "wpbooking"),
							"guest"               => __("Guest", "wpbooking"),
//							"customer_confirm"    => __("Require Customer Confirm?", "wpbooking"),
//							"partner_confirm"     => __("Require Partner Confirm?", "wpbooking"),
						)
					),
					array(
						'name'  => 'title',
						'label' => __('Title', "wpbooking"),
						'type'  => "text",
						'value' => ""
					),
					array(
						'name'  => 'placeholder',
						'label' => __('Placeholder', "wpbooking"),
						'desc'  => __('Placeholder', "wpbooking"),
						'type'  => 'text',
					),
					array(
						'name'    => 'taxonomy',
						'label'   => __('- Taxonomy', "wpbooking"),
						'type'    => "dropdown",
						'class'   => "hide",
						'options' => $list_taxonomy
					),
					array(
						'name'    => 'taxonomy_show',
						'label'   => __('- Display Style', "wpbooking"),
						'type'    => "dropdown",
						'class'   => "hide",
						'options' => array(
							"dropdown"  => __("Dropdown", "wpbooking"),
							"check_box" => __("Check Box", "wpbooking"),
						)
					),
					array(
						'name'    => 'taxonomy_operator',
						'label'   => __('- Operator', "wpbooking"),
						'type'    => "dropdown",
						'class'   => "hide",
						'options' => array(
							"AND" => __("And", "wpbooking"),
							"OR"  => __("Or", "wpbooking"),
						)
					),
					array(
						'name'    => 'required',
						'label'   => __('Required', "wpbooking"),
						'type'    => "dropdown",
						'options' => array(
							"no"  => __("No", "wpbooking"),
							"yes" => __("Yes", "wpbooking"),
						)
					),
					array(
						'name'  => 'in_more_filter',
						'label' => __('Into More Filter?', "wpbooking"),
						'type'  => "checkbox",
					),
				),
				'tour' => array(
					array(
						'name'  => 'title',
						'label' => __('Title', "wpbooking"),
						'type'  => "text",
						'value' => ""
					),

				)
			);
			$list_filed = apply_filters("wpbooking_list_fields_form_search", $list_filed);

			return $list_filed;
		}


		/**
		 *
		 */
		function _show_single_service($template)
		{

			if (get_post_type() == 'wpbooking_service' and is_single()) {
				$template = wpbooking_view_path('single-service');
			}

			return $template;
		}

		/**
		 * Add Review Stats in End of the Content Text
		 * @param $content
		 * @return string
		 */
		function _show_review_stats($content)
		{
			$comnent_id = get_comment_ID();
			$comemntObj = get_comment($comnent_id);
			$post_id = $comemntObj->comment_post_ID;
			if (get_post_type($post_id) != 'wpbooking_service') return $content;

			$content = wpbooking_load_view('single/review/review-item-stats') . $content;

			return $content;
		}

		/**
		 * Save Comment Stats Data
		 * @param $comment_id
		 * @return bool
		 */
		function _save_review_stats($comment_id)
		{
			$comemntObj = get_comment($comment_id);
			$post_id = $comemntObj->comment_post_ID;

			if (get_post_type($post_id) != 'wpbooking_service') return FALSE;

			$validate = apply_filters('wpbooking_save_review_stats_validate', TRUE, $post_id, $comment_id);

			if ($validate) {

				update_comment_meta($comment_id, 'wpbooking_review', WPBooking_Input::post('wpbooking_review'));
				update_comment_meta($comment_id, 'wpbooking_review_detail', WPBooking_Input::post('wpbooking_review_detail'));
			}

			do_action('after_wpbooking_update_review_stats', $validate, $comment_id, $post_id);
		}

		function add_review_field($fields)
		{
//			if (get_post_type() != 'wpbooking_service') return $fields;
//
//			$field_review = apply_filters('wpbooking_review_field', wpbooking_load_view('single/review/review-field'));
//
//			return $field_review . $fields;
		}

		/**
		 * Get All Registered Service Types
		 *
		 * @author dungdt
		 * @since 1.0
		 *
		 * @return mixed|void
		 */
		function get_service_types()
		{
			$default = array();

			return apply_filters('wpbooking_service_types', $default);
		}


		/**
		 * Get Service Type Object by Type ID
		 * @since 1.0
		 * @author dungdt
		 *
		 * @param bool|FALSE $type
		 * @return bool|object
		 */
		function get_service_type($type = FALSE)
		{
			$all = $this->get_service_types();

			if ($type and isset($all[$type])) return $all[$type];
		}

		/**
		 * Filter to load our specific reviews template
		 *
		 * @since 1.0
		 * @author dungdt
		 *
		 * @param $template
		 * @return string
		 */
		function _comments_template($template)
		{
			if (get_post_type() != 'wpbooking_service') return $template;

			$template = wpbooking_view_path('reviews');

			return $template;
		}

		/**
		 * Ajax Vote for Review handler
		 *
		 * @since 1.0
		 * @author dungdt
		 */
		function _wpbooking_vote_review()
		{
			$res = array(
				'status' => FALSE
			);
			$review_id = WPBooking_Input::post('review_id');
			if (!is_user_logged_in()) {
				$res['status'] = FALSE;
				$res['not_logged_in'] = 1;
			} else {
				$model = WPBooking_Review_Helpful_Model::inst();

				$res['voted'] = (int)$model->vote($review_id, get_current_user_id());
				$res['status'] = 1;
				if ($count = $model->count($review_id)) {
					$res['vote_count'] = sprintf(esc_html__('%d like this', 'wpbooking'), $count);
				} else {
					$res['vote_count'] = '';
				}

			}

			echo json_encode($res);
			die;
		}

		/**
		 * Ajax Reply for Review
		 *
		 * @since 1.0
		 * @author dungdt
		 */
		function _wpbooking_write_reply()
		{
			$res = array(
				'status' => FALSE
			);
			$review_id = $this->post('review_id');
			$message = $this->post('message');
			if ($review_id and $message and is_user_logged_in()) {

				$review = get_comment($review_id);
				$post_id = $review->comment_post_ID;
				$service = new WB_Service($post_id);

				// Only Level 1 and check current user permission
				if (wpbooking_review_allow_reply($review_id)) {
					$current_user = wp_get_current_user();
					$data = array(
						'comment_content'      => $message,
						'comment_parent'       => $review_id,
						'user_id'              => get_current_user_id(),
						'comment_author_IP'    => $this->ip_address(),
						'comment_author_email' => $current_user->user_email,
						'comment_post_ID'      => $post_id
					);
					$reply_id = wp_insert_comment($data);
					$count = WPBooking_User::inst()->count_reviews($service->get_author('email'));
					$html_count = FALSE;
					if ($count) $html_count = sprintf('<span class="review-count">' . _n('1 review', '%d reviews', $count, 'wpbooking') . '</span>', $count);

					$res['status'] = 1;
					$res['html'] = '<li>
										<div class="comment_container">
											<footer class="comment-meta">
												<div class="comment-author vcard">
													' . $service->get_author('avatar')
						. sprintf('<b class="review-author-name">%s</b>', $service->get_author('name'))
						. $html_count . '
												</div><!-- .comment-author -->
											</footer><!-- .comment-meta -->

											<div class="comment-content-wrap">
												<div class="comment-text">
													' . $message . '
												</div>
											</div><!-- .comment-content -->
										</div>
									</li>';

					$res['html'] = apply_filters('wpbooking_write_reply_html_result', $res['html'], $reply_id);

				}
			}

			$res = apply_filters('wpbooking_write_reply_result', $res);

			echo json_encode($res);
			die;
		}

		static function inst()
		{
			if (!self::$_inst) {
				self::$_inst = new self();
			}

			return self::$_inst;
		}


	}

	WPBooking_Service_Controller::inst();
}