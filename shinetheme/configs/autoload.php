<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 3/11/2016
 * Time: 10:38 AM
 */

/**
 * @see Traveler_Loader::_autoload();
 */
$autoload['config']=array(
	'settings'
);

$autoload['helper']=array(
	'application',
	'assets',
    'settings'
);


$autoload['library']=array(
    'input',
    'assets',
	'session',
	'currency',
	'validator',
	'metabox'
);

$autoload['controller']=array(
	'service',
	'admin/location',
	'admin/taxonomy',
	'admin/service',
	'admin/form-builder',
    'admin/settings',
	'admin/taxonomy',
	'admin/test-metabox',
	'gateways'
);

$autoload['encrypr_key'] = 'traveler';
