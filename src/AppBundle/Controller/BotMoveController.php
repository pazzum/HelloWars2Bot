<?php

namespace AppBundle\Controller;

use AppBundle\Enum\BotActionEnum;
use AppBundle\Enum\MoveDirectionEnum;
use AppBundle\Model\BattlefieldInfo;
use AppBundle\Model\BotMove;
use AppBundle\Util\DecisionMaker;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class BotMoveController
 * @package AppBundle\Controller
 */
class BotMoveController extends FOSRestController
{
    /**
     * @Rest\Route("PerformNextMove")
     *
     * @ParamConverter("battlefieldInfo", converter="fos_rest.request_body")
     * @param BattlefieldInfo $battlefieldInfo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function performNextMoveAction(BattlefieldInfo $battlefieldInfo, ConstraintViolationListInterface $validationErrors) {
        $data = array();
        if (count($validationErrors) > 0) {
            $data = array('error' => 'yes');
        }
        else {
            $decisionMaker = new DecisionMaker();
            $config = $battlefieldInfo->getGameConfig();
            $data = $decisionMaker->make($battlefieldInfo, $config);
        }

        $view = $this->view($data);
        return $this->handleView($view);
    }
}