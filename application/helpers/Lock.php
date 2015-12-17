<?php

class App_Helper_Lock {

    private $_nameLock;

    /**
     * @return string
     */
    private function _getFile()
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.$this->_nameLock;
    }

    public function __construct($nameLock)
    {
        $this->_nameLock = $nameLock . '.lock';
    }

    /**
     * @return bool
     */
    public function isLock()
    {
        return file_exists($this->_getFile());
    }

    public function unlock()
    {
        unlink($this->_getFile());
    }

    public function lock()
    {
        file_put_contents($this->_getFile(), time());
    }
}