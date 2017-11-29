<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 29.11.2017
 * Time: 00:22
 */

namespace AppBundle\Model;


class Explodable
{
    /**
     * @var string $location
     * @Serializer\SerializedName("Location")
     * @Serializer\Type("string")
     */
    protected $location;
    /**
     * @var integer $explosionRadius
     * @Serializer\SerializedName("ExplosionRadius")
     * @Serializer\Type("integer")
     */
    protected $explosionRadius;

    /**
     * @param Location $botLocation
     */
    public function isDangerous($botLocation) {
        $location = $this->parseLocation();

        if(
            $location->getX() - $this->explosionRadius <= $botLocation->getX() - $this->explosionRadius ||
            $location->getX() + $this->explosionRadius <= $botLocation->getX() + $this->explosionRadius ||
            $location->getY() + $this->explosionRadius <= $botLocation->getY() + $this->explosionRadius ||
            $location->getY() - $this->explosionRadius <= $botLocation->getY() - $this->explosionRadius
        ) return true;
    }

    /**
     * @return Location
     */
    private function parseLocation() {
        list($x, $y) = explode(",", $this->location);
        return new Location($x, $y);
    }
}