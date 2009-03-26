<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID/SoftBank/SerialNumber.php';


$lime = new lime_test(null, new lime_output_color());


$module = new Net_UserAgent_Mobile_UserID_SoftBank_SerialNumber();


$sample = array(
    '1234567890A'     => 'J-PHONE/4.0/J-SH51/SN1234567890A SH/0001a Profile/MIDP-1.0 Configuration/CLDC-1.0 Ext-Profile/JSCL-1.1.0',
    '1234567890ABCDE' => 'Vodafone/1.0/V904SH/SHJ001/SN1234567890ABCDE Browser/VF-NetFront/3.3 Profile/MIDP-2.0 Configuration/CLDC-1.1',
);
foreach ($sample as $sample_id => $sample_ua) {
    $_SERVER['HTTP_USER_AGENT'] = $sample_ua;
    $userid = $module->getID();
    $lime->is('SN'.$sample_id, $userid);

    $ret = $module->validateID($userid);
    $lime->is(true, $ret);

    list($prefix, $id) = $module->parseID($userid);
    $lime->is('SN', $prefix);
    $lime->is($sample_id, $id);
}



$_SERVER['HTTP_USER_AGENT'] = 'J-PHONE/2.0/J-T03';
$userid = $module->getID();
$lime->is(null, $userid);

$ret = $module->validateID($userid);
$lime->is(false, $ret);
