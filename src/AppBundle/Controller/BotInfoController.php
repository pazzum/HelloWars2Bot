<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 20.11.2017
 * Time: 21:16
 */

namespace AppBundle\Controller;


use AppBundle\Model\BotInfo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class BotInfoController
 * @package AppBundle\Controller
 */
class BotInfoController extends FOSRestController
{
    const NAME = "tysioncszejset";
    const AVATAR_URL = "http://avatarmaker.com/svgavatars/temp-avatars/svgA007821769008182544.png";
    const DESCRIPTION = "Most jeezy bot.";
    const GAME_TYPE = "TankBlaster";

    /**
     * @Rest\Route("Info")
     */
    public function infoAction() {
        $data = new BotInfo(
            self::NAME,
            self::AVATAR_URL,
            self::DESCRIPTION,
            self::GAME_TYPE
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
}