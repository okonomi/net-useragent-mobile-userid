<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_Emobile_UID extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (array_key_exists('HTTP_X_EM_UID', $_SERVER)) {
            $id = $_SERVER['HTTP_X_EM_UID'];
        } else {
            $id = null;
        }

        return $id;
    }

    public function validateID($id)
    {
        if (preg_match('/^u.{17}$/', $id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _parseID($id)
    {
        return array('u', substr($id, 1));
    }
}
