<?php
set_time_limit(0);


class Date
{
    private $year, $month, $day;
    public function __construct($str)
    {
        $str = explode("-", $str);
        $this->year = $str[0];
        $this->month = $str[1];
        $this->day = $str[2];
    }
    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

}

?>