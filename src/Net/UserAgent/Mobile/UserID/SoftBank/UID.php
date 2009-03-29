<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_SoftBank_UID extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (array_key_exists('HTTP_X_JPHONE_UID', $_SERVER)) {
            $id = $_SERVER['HTTP_X_JPHONE_UID'];
        } else {
            $id = null;
        }

        return $id;
    }

    public function validateID($id)
    {
        if (preg_match('/^[a-zA-Z0-9]{16}$/i', $id)) {
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
