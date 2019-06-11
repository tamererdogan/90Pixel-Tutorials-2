<?php

namespace App\EventListener;

use App\Entity\ScoreBoard;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ScoreBoardListener
{
    public function postUpdate(ScoreBoard $sb, LifecycleEventArgs $args)
    {		
		$entityManager = $args->getObjectManager();
		
		$point = ($sb->getWin()*3) + $sb->getDraw();
		$average = ($sb->getHomeGoals() - $sb->getAwayGoals());
		
		$sb->setPoint($point);
		$sb->setAverage($average);

		$entityManager->persist($sb);
		$entityManager->flush();
		
		$teams = $entityManager->getRepository(ScoreBoard::class)->findBy([],['point' => 'DESC', 'average' => 'DESC	']);
		$rank = 1;
		foreach($teams as $team)
		{
			$team->setRank($rank);
			$entityManager->persist($team);
			$entityManager->flush();
			$rank++;			
		}
    }   
}
