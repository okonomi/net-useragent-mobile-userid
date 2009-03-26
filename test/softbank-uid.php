<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID/SoftBank/UID.php';


$lime = new lime_test(null, new lime_output_color());


$module = new Net_UserAgent_Mobile_UserID_SoftBank_UID();



$_SERVER['HTTP_X_JPHONE_UID'] = '1234567890ABCDEF';
$userid = $module->getID();
$lime->is('1234567890ABCDEF', $userid);

$ret = $module->validateID($userid);
$lime->is(true, $ret);

list($prefix, $id) = $module->parseID($userid);
$lime->is('', $prefix);
$lime->is('1234567890ABCDEF', $id);



$_SERVER['HTTP_X_JPHONE_UID'] = '1234567aaa';
$userid = $module->getID();
$lime->is('1234567aaa', $userid);

$ret = $module->validateID($userid);
$lime->is(false, $ret);
