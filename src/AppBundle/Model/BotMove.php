<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class BotMove
{
    /** @var integer
     *  @Serializer\SerializedName("Direction")
     */
    private $direction;
    /**
     * @var integer
     * @Serializer\SerializedName("Action")
     */
    private $action;
    /**
     * @var integer
     * @Serializer\SerializedName("FireDirection")
     */
    private $fireDirection;

    /**
     * BotMove constructor.
     * @param $direction
     * @param $action
     * @param $fireDirection
     */
    public function __construct($direction, $action, $fireDirection)
    {
        $this->direction = $direction;
        $this->action = $action;
        $this->fireDirection = $fireDirection;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return int
     */
    public function getFireDirection()
    {
        return $this->fireDirection;
    }
}