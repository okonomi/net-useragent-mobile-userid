<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_SoftBank_SerialNumber extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return null;
        }

        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('!^J-PHONE/[0-9\.]+/.*?/(SN[A-Z0-9]{11}) !', $useragent, $match)) {
            $ret = $match[1];
        } elseif (preg_match('!^(Vodafone|SoftBank)/[0-9\.]+/.*?/.*?/(SN[A-Z0-9]{15}) !', $useragent, $match)) {
            $ret = $match[2];
        } else {
            $ret = null;
        }

        return $ret;
    }

    public function validateID($id)
    {
        if (preg_match('/^SN([A-Z0-9]{11}|[A-Z0-9]{15})$/', $id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _parseID($id)
    {
        return array('SN', substr($id, 2));
    }
}
