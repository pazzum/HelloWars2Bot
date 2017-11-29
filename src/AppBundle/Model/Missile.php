<?php

namespace AppBundle\Model;


class Missile extends Explodable
{
    private $moveDirection;

    public function __construct($moveDirection, $location, $explosionRadius) {
        $this->moveDirection = $moveDirection;
        $this->location = $location;
        $this->explosionRadius = $explosionRadius;
    }
}