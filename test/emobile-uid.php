<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID/Emobile/UID.php';


$lime = new lime_test(null, new lime_output_color());


$module = new Net_UserAgent_Mobile_UserID_Emobile_UID();



$_SERVER['HTTP_X_EM_UID'] = 'u1234567890abcdefgh';
$userid = $module->getID();
$lime->is('u1234567890abcdefgh', $userid);

$ret = $module->validateID($userid);
$lime->is(true, $ret);

list($prefix, $id) = $module->parseID($userid);
$lime->is('u', $prefix);
$lime->is('1234567890abcdefgh', $id);



$_SERVER['HTTP_X_EM_UID'] = '1234567aaa';
$userid = $module->getID();
$lime->is('1234567aaa', $userid);

$ret = $module->validateID($userid);
$lime->is(false, $ret);
