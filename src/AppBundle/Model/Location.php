<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 26.11.2017
 * Time: 16:53
 */

namespace AppBundle\Model;


class Location
{
    private $x;
    private $y;

    /**
     * Location constructor.
     * @param integer $x
     * @param integer $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }
}