<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 3/11/2016
 * Time: 10:38 AM
 */

/**
 * @see WPBooking_Loader::_autoload();
 */
$autoload['config']=array(
	'config',
	'lang'
);

$autoload['helper']=array(
	'application',
	'assets',
    'settings',
    'form-build',
    'service',
	'email',
    'template-func'
);

$autoload['library']=array(
	'helper',
    'input',
    'assets',
	'session',
	'currency',
	'validator',
	'metabox',
	'email/emogrifier',
	'query',
	'base/service',
	'base/order',
	//'base/coupon',
    'base/chart',
	'taxonomy-metabox',
	'query-inject',
    'service',
    'captcha',
    'comments'
);

$autoload['controller']=array(
	'user',
	'service',
	'order',
	'admin/order',
    //'admin/coupon',
	'admin/location',
	'admin/taxonomy',
	'admin/service',
    'admin/about',
    'admin/settings',
	'admin/taxonomy',
	'admin/calendar.metabox',
	'admin/setup',
	'gateways',
	'email',
	'checkout',
);

$autoload['model']=array(
	'service_model',
	'order_model',
	'order_hotel_room_model',
	'calendar_model',
	'payment_model',
	'comments_model',
	'inbox_model',
	'user_favorite_model',
	'review_helpful',
    'query_model',
    'meta_model',
    'user_model'
);

$autoload['widget']=array(
    'search-form',
    'currency-switcher',
	'cart-widget'
);

$autoload['frontend'] = array(
    'template-hooks'
);

$autoload['encrypr_key'] = 'wpbooking';
