<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class BotInfo
{
    /**
     * @var string
     * @Serializer\SerializedName("Name")
     */
    private $name;
    /**
     * @var string
     * @Serializer\SerializedName("AvatarUrl")
     */
    private $avatarUrl;
    /**
     * @var string
     * @Serializer\SerializedName("Description")
     */
    private $description;
    /**
     * @var string
     * @Serializer\SerializedName("GameType")
     */
    private $gameType;

    /**
     * BotInfo constructor.
     * @param $name
     * @param $avatarUrl
     * @param $description
     * @param $gameType
     */
    public function __construct($name, $avatarUrl, $description, $gameType)
    {
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
        $this->description = $description;
        $this->gameType = $gameType;
    }
}