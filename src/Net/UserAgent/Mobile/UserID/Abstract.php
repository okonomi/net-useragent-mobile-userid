<?php
require_once 'Net/UserAgent/Mobile/UserID/Exception.php';


abstract class Net_UserAgent_Mobile_UserID_Abstract
{
    abstract public function getID();
    abstract public function validateID($id);
    abstract protected function _parseID($id);

    public function parseID($id = null)
    {
        if (is_null($id)) {
            $id = $this->getID();
            if (is_null($id)) {
                throw new Net_UserAgent_Mobile_UserID_Exception();
            }
        }
        if (!$this->validateID($id)) {
            throw new Net_UserAgent_Mobile_UserID_Exception();
        }

        $ret = $this->_parseID($id);
        $ret[] = $id;

        return $ret;
    }
}
