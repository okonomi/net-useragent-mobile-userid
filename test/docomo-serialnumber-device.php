<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID/DoCoMo/SerialNumber/Device.php';


$lime = new lime_test(null, new lime_output_color());


$module = new Net_UserAgent_Mobile_UserID_DoCoMo_SerialNumber_Device();


$sample = array(
    '1234567890a'     => 'DoCoMo/1.0/X503i/c10/ser1234567890a',
    'XXXXXXXXXXXXXXX' => 'DoCoMo/2.0 P2101V(c100;serXXXXXXXXXXXXXXX;iccxxxxxxxxxxxxxxxxxxxx)',
);
foreach ($sample as $sample_id => $sample_ua) {
    $_SERVER['HTTP_USER_AGENT'] = $sample_ua;
    $userid = $module->getID();
    $lime->is('ser'.$sample_id, $userid);

    $ret = $module->validateID($userid);
    $lime->is(true, $ret);

    list($prefix, $id) = $module->parseID($userid);
    $lime->is('ser', $prefix);
    $lime->is($sample_id, $id);
}



$_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/1.0/X503i';
$userid = $module->getID();
$lime->is(null, $userid);

$ret = $module->validateID($userid);
$lime->is(false, $ret);
