<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID/DoCoMo/ImodeID.php';


$lime = new lime_test(null, new lime_output_color());


$module = new Net_UserAgent_Mobile_UserID_DoCoMo_ImodeID();



$_SERVER['HTTP_X_DCMGUID'] = '1234567';
$userid = $module->getID();
$lime->is('1234567', $userid);

$ret = $module->validateID($userid);
$lime->is(true, $ret);

list($prefix, $id) = $module->parseID($userid);
$lime->is('', $prefix);
$lime->is('1234567', $id);



$_SERVER['HTTP_X_DCMGUID'] = '1234567aaa';
$userid = $module->getID();
$lime->is('1234567aaa', $userid);

$ret = $module->validateID($userid);
$lime->is(false, $ret);
