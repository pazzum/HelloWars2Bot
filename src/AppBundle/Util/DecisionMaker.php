<?php

namespace AppBundle\Util;
use AppBundle\Enum\BoardTileEnum;
use AppBundle\Enum\BotActionEnum;
use AppBundle\Enum\MoveDirectionEnum;
use AppBundle\Model\BattlefieldInfo;
use AppBundle\Model\Bomb;
use AppBundle\Model\BotMove;
use AppBundle\Model\Config;
use AppBundle\Model\Location;
use AppBundle\Model\Missile;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 23.11.2017
 * Time: 00:55
 */
class DecisionMaker
{
    /**
     * @param BattlefieldInfo $battlefieldInfo
     * @param Config $config
     * @return BotMove
     */
    public function make(BattlefieldInfo $battlefieldInfo, $config) {
        $possibleMoves = $this->getPossibleMoves($battlefieldInfo, $config);
        $rankedMoves = $this->rateMoves($possibleMoves, $battlefieldInfo, $config);
        return $this->getBestMove($rankedMoves);
    }

    /**
     * @param array $ratedMoves
     * @return BotMove
     */
    public function getBestMove(array $ratedMoves) {
        usort($ratedMoves, function ($item1, $item2) {
            return $item2['rate'] <=> $item1['rate'];
        });

        $profitableMoves = array_column($ratedMoves, 'possibleMove');

        return reset($profitableMoves);
    }

    /**
     * @param BattlefieldInfo $battlefieldInfo
     * @param Config $config
     * @return BotMove[]
     */
    public function getPossibleMoves(BattlefieldInfo $battlefieldInfo, Config $config) {
        $possibleMoves = array();

        //No moving
        $possibleMoves[] = $this->makeNoMove();

        //No moving droping the bomb
        $possibleMoves[] = $this->makeNoMoveDrop();

        //Just moving and moving and dropping the bomb
        if($this->isFieldEmpty(MoveDirectionEnum::UP, $battlefieldInfo, $config)) {
            $possibleMoves[] = $this->makeOnlyMoveUp();
            $possibleMoves[] = $this->makeOnlyMoveUpDrop();
        }
        if($this->isFieldEmpty(MoveDirectionEnum::DOWN, $battlefieldInfo, $config)) {
            $possibleMoves[] = $this->makeOnlyMoveDown();
            $possibleMoves[] = $this->makeOnlyMoveDownDrop();
        }
        if($this->isFieldEmpty(MoveDirectionEnum::LEFT, $battlefieldInfo, $config)) {
            $possibleMoves[] = $this->makeOnlyMoveLeft();
            $possibleMoves[] = $this->makeOnlyMoveLeftDrop();
        }
        if($this->isFieldEmpty(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config)) {
            $possibleMoves[] = $this->makeOnlyMoveRight();
            $possibleMoves[] = $this->makeOnlyMoveRightDrop();
        }

        //Moving and shooting
        if($this->isFieldEmpty(MoveDirectionEnum::UP, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::UP, $battlefieldInfo, $config)
        )
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::UP
        );
        if($this->isFieldEmpty(MoveDirectionEnum::UP, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::DOWN, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::DOWN
        );
        if($this->isFieldEmpty(MoveDirectionEnum::UP, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::RIGHT
        );
        if($this->isFieldEmpty(MoveDirectionEnum::UP, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::LEFT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::LEFT
        );

        if($this->isFieldEmpty(MoveDirectionEnum::DOWN, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::UP, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::UP
        );
        if($this->isFieldEmpty(MoveDirectionEnum::DOWN, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::DOWN, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::DOWN
        );
        if($this->isFieldEmpty(MoveDirectionEnum::DOWN, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::RIGHT
        );
        if($this->isFieldEmpty(MoveDirectionEnum::DOWN, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::LEFT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::LEFT
        );

        if($this->isFieldEmpty(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::UP, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::UP
        );
        if($this->isFieldEmpty(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::DOWN, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::DOWN
        );
        if($this->isFieldEmpty(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::RIGHT
        );
        if($this->isFieldEmpty(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::LEFT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::LEFT
        );

        if($this->isFieldEmpty(MoveDirectionEnum::LEFT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::UP, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::UP
        );
        if($this->isFieldEmpty(MoveDirectionEnum::LEFT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::DOWN, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::DOWN
        );
        if($this->isFieldEmpty(MoveDirectionEnum::LEFT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::RIGHT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::RIGHT
        );
        if($this->isFieldEmpty(MoveDirectionEnum::LEFT, $battlefieldInfo, $config) &&
            $this->isAdjacentDestroyable(MoveDirectionEnum::LEFT, $battlefieldInfo, $config))
        $possibleMoves[] = new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::FIRE_MISSILE,
            MoveDirectionEnum::LEFT
        );

        return $possibleMoves;
    }

    /**
     * @param integer $direction
     * @param BattlefieldInfo $battlefieldInfo
     * @param Config $config
     * @return boolean
     */
    private function isFieldEmpty($direction, $battlefieldInfo, $config) {
        $botLocation = $battlefieldInfo->getBotLocation();
        list($botXLocation, $botYlocation) = explode(",", $botLocation);
        $board = $battlefieldInfo->getBoard();

        switch ($direction) {
            case MoveDirectionEnum::UP:
                if(
                    $botYlocation != 0 &&
                    $board[$botXLocation][$botYlocation-1] == BoardTileEnum::EMTPY
                ) return true;
                break;
            case MoveDirectionEnum::DOWN:
                if(
                    $botYlocation != $config->getMapHeight() &&
                    $board[$botXLocation][$botYlocation+1] == BoardTileEnum::EMTPY
                ) return true;
                break;
            case MoveDirectionEnum::RIGHT:
                if(
                    $botYlocation != $config->getMapWidth() &&
                    $board[$botXLocation+1][$botYlocation] == BoardTileEnum::EMTPY
                ) return true;
                break;
            case MoveDirectionEnum::LEFT:
                if(
                    $botYlocation != 0 &&
                    $board[$botXLocation-1][$botYlocation] == BoardTileEnum::EMTPY
                ) return true;
        }

        return false;
    }

    /**
     * @param integer $direction
     * @param BattlefieldInfo $battlefieldInfo
     * @param Config $config
     * @return boolean
     */
    private function isAdjacentDestroyable($direction, $battlefieldInfo, $config) {
        $botLocation = $battlefieldInfo->getBotLocation();
        list($botXLocation, $botYlocation) = explode(",",$botLocation);
        $board = $battlefieldInfo->getBoard();

        switch ($direction) {
            case MoveDirectionEnum::UP:
                if(
                    $botYlocation != 0 &&
                    $board[$botXLocation][$botYlocation-1] != BoardTileEnum::INDESTRUCTIBLE
                ) return true;
                break;
            case MoveDirectionEnum::DOWN:
                if(
                    $botYlocation != $config->getMapHeight() &&
                    $board[$botXLocation][$botYlocation+1] != BoardTileEnum::INDESTRUCTIBLE
                ) return true;
                break;
            case MoveDirectionEnum::RIGHT:
                if(
                    $botXLocation != $config->getMapWidth() &&
                    $board[$botXLocation+1][$botYlocation] != BoardTileEnum::INDESTRUCTIBLE
                ) return true;
                   break;
            case MoveDirectionEnum::LEFT:
                if(
                    $botXLocation != 0 &&
                    $board[$botXLocation-1][$botYlocation] != BoardTileEnum::INDESTRUCTIBLE
                ) return true;
        }

        return false;

    }

    private function makeNoMove() {
        return new BotMove(
            null,
            BotActionEnum::NONE,
            null
        );
    }

    private function makeOnlyMoveUp() {
        return new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::NONE,
            null
        );
    }

    private function makeOnlyMoveDown() {
        return new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::NONE,
            null
        );
    }

    private function makeOnlyMoveRight() {
        return new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::NONE,
            null
        );
    }

    private function makeOnlyMoveLeft() {
        return new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::NONE,
            null
        );
    }

    private function makeNoMoveDrop() {
        return new BotMove(
                null,
                BotActionEnum::DROP_BOMB,
                null
            );
    }

    private function makeOnlyMoveUpDrop() {
        return new BotMove(
            MoveDirectionEnum::UP,
            BotActionEnum::DROP_BOMB,
            null
        );
    }

    private function makeOnlyMoveDownDrop() {
        return new BotMove(
            MoveDirectionEnum::DOWN,
            BotActionEnum::DROP_BOMB,
            null
        );
    }

    private function makeOnlyMoveRightDrop() {
        return new BotMove(
            MoveDirectionEnum::RIGHT,
            BotActionEnum::DROP_BOMB,
            null
        );
    }

    private function makeOnlyMoveLeftDrop() {
        return new BotMove(
            MoveDirectionEnum::LEFT,
            BotActionEnum::DROP_BOMB,
            null
        );
    }

    /**
     * @param BotMove[] $possibleMoves
     * @param BattlefieldInfo $battlefieldInfo
     * @param Config $config
     */
    private function rateMoves($possibleMoves, $battlefieldInfo, $config) {
        $locations = $this->parseOpponentLocations($battlefieldInfo->getOpponentLocations());
        $botLocation = $this->parseBotLocation($battlefieldInfo->getBotLocation());
        $opponents = $this->getOpponentsAtAdjacentTiles($locations, $botLocation);

        $ratedMoves = array();

        foreach ($possibleMoves as $possibleMove) {
            $rate = 0;

            $rate += $this->rateMovement(
                $possibleMove->getDirection(),
                $botLocation,
                $battlefieldInfo->getBombs(),
                $battlefieldInfo->getMissiles());

            //przeciwnik jest obok strzel pocisk
            $rate += $this->rateShootingToOpponent($possibleMove->getFireDirection(), $opponents);

                //strzel w najblizszy destrukcyjny przedmiot
                //ucieknij od niego

             //przeciwnik jest x pol obok
                //rozstaw bombe
             //bomba wybuchnie x pol obok
             //bomba wybychnue obok
             //przeciwnik jest tylko 1 lbu 2 obszarze na ktorym jest bomba i jest najkrotsza droga
             //nikogo nie ma i jest destroyable

            $ratedMoves[] = array(
                'rate' => $rate,
                'possibleMove' => $possibleMove
            );
        }

        //delete with 0 rate

        return $ratedMoves;
    }

    /**
     * @param Location[] $locationsArray
     * @return Location[]
     */
    private function parseOpponentLocations($locationsArray) {
        $locations = array();
        foreach ($locationsArray as $locationArray) {
            $locations[] = $this->parseBotLocation($locationArray);
        }
        return $locations;
    }

    /**
     * @param string $locationsString
     * @return Location
     */
    private function parseBotLocation($locationsString) {
        list($locationX, $locationY) = explode(",", $locationsString);
        return new Location($locationX, $locationY);
    }

    /**
     * @param Location[] $locations
     * @param Location $botLocation
     */
    private function getOpponentsAtAdjacentTiles($locations, $botLocation) {
        $opponents = null;
        foreach ($locations as $location) {
            $opponents[] = $this->getBotAdjacentship($location, $botLocation);
        }
        return $opponents;
    }

    /**
     * @param Location $opponentLocation
     * @param Location $botLocation
     * @return integer|null
     */
    private function getBotAdjacentship($opponentLocation, $botLocation) {
        //jest na gorze
            if($opponentLocation->getX() == $botLocation->getX() &&
                $opponentLocation->getY()-1 == $botLocation->getY()
            ) return MoveDirectionEnum::UP;
            //jest na dole
            if($opponentLocation->getX() == $botLocation->getX() &&
                $opponentLocation->getY()+1 == $botLocation->getY()
            ) return MoveDirectionEnum::DOWN;
            //jest na lewo
            if($opponentLocation->getX()-1 == $botLocation->getX() &&
                $opponentLocation->getY() == $botLocation->getY()
            ) return MoveDirectionEnum::LEFT;
            //jest na prawo
            if($opponentLocation->getX() +1 == $botLocation->getX() &&
                $opponentLocation->getY() == $botLocation->getY()
            ) return MoveDirectionEnum::RIGHT;
            return null;
    }

    /**
     * @param integer $botMove
     * @param Location $botLocation
     * @param Bomb[] $bombs
     * @param Missile[] $missiles
     * @return double
     */
    private function rateMovement($botMove, $botLocation, $bombs, $missiles) {
        $newLocation = $this->getLocationAfterMove($botMove, $botLocation);

        $dangerousBombs = 0;
        $dangerousMissiles = 0;

        foreach ($bombs as $bomb) {
            $bomb = new Bomb($bomb["RoundsUntilExplodes"], $bomb["Location"], $bomb["ExplosionRadius"]);
            if($bomb->isDangerous($newLocation)) $dangerousBombs++;
        }

        foreach ($missiles as $missile) {
            $missile = new Missile($missile["MoveDirection"],$missile["Location"],$missile["ExplosionRadius"]);
            if($missile->isDangerous($newLocation)) $dangerousMissiles++;
        }

        $sumOfExplodables = count($bombs) + count($missiles);

        return ($dangerousMissiles+$dangerousMissiles)/$sumOfExplodables;
    }

    /**
     * @param $botMove
     * @param Location $botLocation
     * @return Location|null
     */
    private function getLocationAfterMove($botMove, $botLocation) {
        $newLocation = null;
        switch ($botMove) {
            case MoveDirectionEnum::UP:
                $newLocation = new Location($botLocation->getX(), $botLocation->getY()-1); break;
            case MoveDirectionEnum::DOWN:
                $newLocation = new Location($botLocation->getX(), $botLocation->getY()+1); break;
            case MoveDirectionEnum::RIGHT:
                $newLocation = new Location($botLocation->getX()+1, $botLocation->getY()); break;
            case MoveDirectionEnum::LEFT:
                $newLocation = new Location($botLocation->getX()-1, $botLocation->getY()); break;
        }
        return $newLocation;
    }

    /**
     * @param $moveDirection
     * @param $opponents
     * @return double
     */
    private function rateShootingToOpponent($moveDirection, $opponents) {
        foreach ($opponents as $opponent) {
            if($moveDirection == $opponent) return 1;
        }
        return 0;
    }
}