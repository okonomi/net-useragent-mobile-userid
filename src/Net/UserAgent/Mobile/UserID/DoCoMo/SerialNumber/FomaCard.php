<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_DoCoMo_SerialNumber_FomaCard extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return null;
        }

        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('!^DoCoMo/2\.0 .*?ser[a-zA-Z0-9]{15};(icc[a-zA-Z0-9]{20})\)$!', $useragent, $match)) {
            $ret = $match[1];
        } else {
            $ret = null;
        }

        return $ret;
    }

    public function validateID($id)
    {
        if (preg_match('/^icc([a-zA-Z0-9]{11}|[a-zA-Z0-9]{20})$/', $id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _parseID($id)
    {
        return array('icc', substr($id, 3));
    }
}
