<?php

namespace App\EventListener;

use App\Entity\Team;
use App\Entity\ScoreBoard;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TeamListener
{
    public function postPersist(Team $team, LifecycleEventArgs $args)
    {
		$scoreBoardItem = new ScoreBoard();
		$scoreBoardItem->setTeam($team);
		
        $entityManager = $args->getObjectManager();
        $entityManager->persist($scoreBoardItem);
		$entityManager->flush();
    }    
}
