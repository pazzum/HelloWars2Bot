<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 21.11.2017
 * Time: 00:41
 */

namespace AppBundle\Model;
use JMS\Serializer\Annotation as Serializer;


class Bomb extends Explodable
{
    /**
     * @var integer $roundsUntilExplodes
     * @Serializer\SerializedName("RoundsUntilExplodes")
     * @Serializer\Type("integer")
     */
    private $roundsUntilExplodes;

    public function __construct($roundsUntilExplodes, $location, $explosionRadius) {
        $this->roundsUntilExplodes = $roundsUntilExplodes;
        $this->location = $location;
        $this->explosionRadius = $explosionRadius;
    }
}