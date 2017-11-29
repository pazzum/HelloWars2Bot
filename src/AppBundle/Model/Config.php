<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 21.11.2017
 * Time: 00:42
 */

namespace AppBundle\Model;


use JMS\Serializer\Annotation as Serializer;

class Config
{
    /**
     *  @var integer
     *  @Serializer\SerializedName("MapWidth")
     *  @Serializer\Type("integer")
     */
    private $mapWidth;
    /**
     * @var integer
     * @Serializer\SerializedName("MapHeight")
     * @Serializer\Type("integer")
     */
    private $mapHeight;
    /**
     * @var integer
     * @Serializer\SerializedName("BombBlastRadius")
     * @Serializer\Type("integer")
     */
    private $bombBlastRadius;
    /**
     * @var integer
     * @Serializer\SerializedName("MissileBlastRadius")
     * @Serializer\Type("integer")
     */
    private $missileBlastRadius;
    /**
     * @var integer
     * @Serializer\SerializedName("RoundsBetweenMissiles")
     * @Serializer\Type("integer")
     */
    private $roundsBetweenMissiles;
    /**
     * @var integer
     * @Serializer\SerializedName("RoundsBetweenIncreasingBlastRadius")
     * @Serializer\Type("integer")
     */
    private $roundsBeforeIncreasingBlastRadius;
    /**
     * @var boolean
     * @Serializer\SerializedName("IsFastMissileModeEnabled")
     * @Serializer\Type("boolean")
     */
    private $isFastMissileModeEnabled;

    /**
     * Config constructor.
     * @param $mapWidth
     * @param $mapHeight
     * @param $bombBlastRadius
     * @param $missileBlastRadius
     * @param $roundsBetweenMissiles
     * @param $roundsBeforeIncreasingBlastRadius
     * @param $isFastMissileModeEnabled
     */
    public function __construct($mapWidth, $mapHeight, $bombBlastRadius, $missileBlastRadius, $roundsBetweenMissiles, $roundsBeforeIncreasingBlastRadius, $isFastMissileModeEnabled)
    {
        $this->mapWidth = $mapWidth;
        $this->mapHeight = $mapHeight;
        $this->bombBlastRadius = $bombBlastRadius;
        $this->missileBlastRadius = $missileBlastRadius;
        $this->roundsBetweenMissiles = $roundsBetweenMissiles;
        $this->roundsBeforeIncreasingBlastRadius = $roundsBeforeIncreasingBlastRadius;
        $this->isFastMissileModeEnabled = $isFastMissileModeEnabled;
    }

    /**
     * @return mixed
     */
    public function getMapWidth()
    {
        return $this->mapWidth;
    }

    /**
     * @param mixed $mapWidth
     * @return Config
     */
    public function setMapWidth($mapWidth)
    {
        $this->mapWidth = $mapWidth;
        return $this;
    }

    /**
     * @return int
     */
    public function getMapHeight()
    {
        return $this->mapHeight;
    }

    /**
     * @param int $mapHeight
     * @return Config
     */
    public function setMapHeight($mapHeight)
    {
        $this->mapHeight = $mapHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getBombBlastRadius()
    {
        return $this->bombBlastRadius;
    }

    /**
     * @param int $bombBlastRadius
     * @return Config
     */
    public function setBombBlastRadius($bombBlastRadius)
    {
        $this->bombBlastRadius = $bombBlastRadius;
        return $this;
    }

    /**
     * @return int
     */
    public function getMissileBlastRadius()
    {
        return $this->missileBlastRadius;
    }

    /**
     * @param int $missileBlastRadius
     * @return Config
     */
    public function setMissileBlastRadius($missileBlastRadius)
    {
        $this->missileBlastRadius = $missileBlastRadius;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoundsBetweenMissiles()
    {
        return $this->roundsBetweenMissiles;
    }

    /**
     * @param int $roundsBetweenMissiles
     * @return Config
     */
    public function setRoundsBetweenMissiles($roundsBetweenMissiles)
    {
        $this->roundsBetweenMissiles = $roundsBetweenMissiles;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoundsBeforeIncreasingBlastRadius()
    {
        return $this->roundsBeforeIncreasingBlastRadius;
    }

    /**
     * @param int $roundsBeforeIncreasingBlastRadius
     * @return Config
     */
    public function setRoundsBeforeIncreasingBlastRadius($roundsBeforeIncreasingBlastRadius)
    {
        $this->roundsBeforeIncreasingBlastRadius = $roundsBeforeIncreasingBlastRadius;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFastMissileModeEnabled()
    {
        return $this->isFastMissileModeEnabled;
    }

    /**
     * @param bool $isFastMissileModeEnabled
     * @return Config
     */
    public function setIsFastMissileModeEnabled($isFastMissileModeEnabled)
    {
        $this->isFastMissileModeEnabled = $isFastMissileModeEnabled;
        return $this;
    }
}