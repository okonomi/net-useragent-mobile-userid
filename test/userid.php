<?php
error_reporting(E_ALL);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';
require_once 'Net/UserAgent/Mobile/UserID.php';


$lime = new lime_test(null, new lime_output_color);


$_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/1.0 D503i';
$_SERVER['HTTP_X_DCMGUID'] = '1234567';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('', $userid->getPrefix());
$lime->is('1234567', $userid->getID());
$lime->is('1234567', $userid->getRawData());
unset($_SERVER['HTTP_USER_AGENT']);
unset($_SERVER['HTTP_X_DCMGUID']);


$_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/2.0 P2101V(c100;serXXXXXXXXXXXXXXX;iccxxxxxxxxxxxxxxxxxxxx)';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('icc', $userid->getPrefix());
$lime->is('xxxxxxxxxxxxxxxxxxxx', $userid->getID());
$lime->is('iccxxxxxxxxxxxxxxxxxxxx', $userid->getRawData());
unset($_SERVER['HTTP_USER_AGENT']);


$_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/1.0/X503i/c10/ser1234567890a';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('ser', $userid->getPrefix());
$lime->is('1234567890a', $userid->getID());
$lime->is('ser1234567890a', $userid->getRawData());
unset($_SERVER['HTTP_USER_AGENT']);


$_SERVER['HTTP_USER_AGENT'] = 'Vodafone/1.0/V904SH/SHJ001/SN1234567890ABCDE';
$_SERVER['HTTP_X_JPHONE_UID'] = '1234567890ABCDEF';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('', $userid->getPrefix());
$lime->is('1234567890ABCDEF', $userid->getID());
$lime->is('1234567890ABCDEF', $userid->getRawData());
unset($_SERVER['HTTP_USER_AGENT']);
unset($_SERVER['HTTP_X_JPHONE_UID']);


$_SERVER['HTTP_USER_AGENT'] = 'Vodafone/1.0/V904SH/SHJ001/SN1234567890ABCDE Browser/VF-NetFront/3.3 Profile/MIDP-2.0 Configuration/CLDC-1.1';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('SN', $userid->getPrefix());
$lime->is('1234567890ABCDE', $userid->getID());
$lime->is('SN1234567890ABCDE', $userid->getRawData());
unset($_SERVER['HTTP_USER_AGENT']);


$_SERVER['HTTP_USER_AGENT'] = 'KDDI-SA31 UP.Browser/6.2.0.7.3.129 (GUI) MMP/2.0';
$_SERVER['HTTP_X_UP_SUBNO'] = '1234567890ABCD_aa.ezweb.ne.jp';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('', $userid->getPrefix());
$lime->is('1234567890ABCD_aa.ezweb.ne.jp', $userid->getID());
$lime->is('1234567890ABCD_aa.ezweb.ne.jp', $userid->getRawData());
unset($_SERVER['HTTP_X_UP_SUBNO']);
unset($_SERVER['HTTP_USER_AGENT']);


/*
$_SERVER['HTTP_X_EM_UID'] = 'u1234567890abcdefgh';
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->is('u', $userid->getPrefix());
$lime->is('1234567890abcdefgh', $userid->getID());
$lime->is('1234567890abcdefgh', $userid->getRawData());
unset($_SERVER['HTTP_X_EM_UID']);
*/


$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('Net_UserAgent_Mobile_UserID', get_class($userid));
$lime->ok('' === $userid->getPrefix());
$lime->ok('' === $userid->getID());
$lime->ok('' === $userid->getRawData());


require_once 'Net/UserAgent/Mobile/UserID/NonMobile.php';
class TestModule extends Net_UserAgent_Mobile_UserID_NonMobile
{
    public function parseID($id = null)
    {
        return array('a', 'b', 'ab');
    }
}
Net_UserAgent_Mobile_UserID::setUserIDModules('NonMobile', new TestModule());
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->is('a', $userid->getPrefix());
$lime->is('b', $userid->getID());
$lime->is('ab', $userid->getRawData());

Net_UserAgent_Mobile_UserID::setUserIDModules('NonMobile', null);
$userid = Net_UserAgent_Mobile_UserID::factory();
$lime->ok('' === $userid->getPrefix());
$lime->ok('' === $userid->getID());
$lime->ok('' === $userid->getRawData());
