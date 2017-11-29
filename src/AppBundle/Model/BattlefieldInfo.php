<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class BattlefieldInfo
{
    /**
     * @var integer
     * @Serializer\SerializedName("RoundNumber")
     * @Serializer\Type("integer")
     */
    private $roundNumber;
    /**
     * @var string
     * @Serializer\SerializedName("BotId")
     * @Serializer\Type("string")
     */
    private $botId;
    /**
     * @var array
     * @Serializer\SerializedName("Board")
     * @Serializer\Type("array")
     */
    private $board;
    /**
     * @var string
     * @Serializer\SerializedName("BotLocation")
     * @Serializer\Type("string")
     */
    private $botLocation;
    /**
     * @var boolean
     * @Serializer\SerializedName("IsMissileAvailable")
     * @Serializer\Type("boolean")
     */
    private $isMissileAvailable;
    /**
     * @var array
     * @Serializer\SerializedName("OpponentLocations")
     * @Serializer\Type("array")
     */
    private $opponentLocations;
    /**
     * @var Bomb[]
     * @Serializer\SerializedName("Bombs")
     * @Serializer\Type("array")
     */
    private $bombs;
    /** @var Missile[]
     *  @Serializer\SerializedName("Missiles")
     *  @Serializer\Type("array")
     */
    private $missiles;
    /**
     * @var Config
     * @Serializer\SerializedName("GameConfig")
     * @Serializer\Type("AppBundle\Model\Config")
     */
    private $gameConfig;

    /**
     * BattlefieldInfo constructor.
     * @param $roundNumber
     * @param $botId
     * @param $board
     * @param $botLocation
     * @param $isMissileAvailable
     * @param $opponentLocations
     * @param $bombs
     * @param $missiles
     * @param $gameConfig
     */
    public function __construct($roundNumber, $botId, $board, $botLocation, $isMissileAvailable, $opponentLocations, $bombs, $missiles, $gameConfig)
    {
        $this->roundNumber = $roundNumber;
        $this->botId = $botId;
        $this->board = $board;
        $this->botLocation = $botLocation;
        $this->isMissileAvailable = $isMissileAvailable;
        $this->opponentLocations = $opponentLocations;
        $this->bombs = $bombs;
        $this->missiles = $missiles;
        $this->gameConfig = $gameConfig;
    }

    /**
     * @return int
     */
    public function getRoundNumber()
    {
        return $this->roundNumber;
    }

    /**
     * @return string
     */
    public function getBotId()
    {
        return $this->botId;
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @return string
     */
    public function getBotLocation()
    {
        return $this->botLocation;
    }

    /**
     * @return bool
     */
    public function isMissileAvailable()
    {
        return $this->isMissileAvailable;
    }

    /**
     * @return array
     */
    public function getOpponentLocations()
    {
        return $this->opponentLocations;
    }

    /**
     * @return Bomb[]
     */
    public function getBombs()
    {
        return $this->bombs;
    }

    /**
     * @return Missile[]
     */
    public function getMissiles()
    {
        return $this->missiles;
    }

    /**
     * @return Config
     */
    public function getGameConfig()
    {
        return $this->gameConfig;
    }
}