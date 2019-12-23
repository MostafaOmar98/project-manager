<?php
set_time_limit(0);


class Entity
{
    private $error = "";

    public function appendError($str)
    {
        if (strlen($this->error) != 0)
            $this->error .= ", ";
        $this->error .= $str;
    }

    public function clearError()
    {
        $this->error = "";
    }

    public function getError()
    {
        return $this->error;
    }
}