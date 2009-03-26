<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_EZweb_SubscriberID extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (array_key_exists('HTTP_X_UP_SUBNO', $_SERVER)) {
            $id = $_SERVER['HTTP_X_UP_SUBNO'];
        } else {
            $id = null;
        }

        return $id;
    }

    public function validateID($id)
    {
        if (preg_match('/^[a-z0-9]{14}_[a-z]{2}\.ezweb\.ne\.jp$/i', $id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _parseID($id)
    {
        return array('', $id);
    }
}
