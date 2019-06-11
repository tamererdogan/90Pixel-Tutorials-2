<?php

namespace App\EventListener;

use App\Entity\FootballMatch;
use App\Entity\ScoreBoard;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class MatchListener
{
    public function postUpdate(FootballMatch $match, LifecycleEventArgs $args)
    {		
		$entityManager = $args->getObjectManager();	
		
		//Ev sahibi takımın scoreboard itemi
		$scoreBoardItem  = $match->getHome()->getScoreBoard();
		//Deplasman takımın scoreboard itemi
		$scoreBoardItem2 = $match->getAway()->getScoreBoard();		

		//Ev Sahibinin Kazanması Durumu
		if($match->getHomeGoals() > $match->getAwayGoals())
		{
			$scoreBoardItem->setWin(($scoreBoardItem->getWin() == null ? 1 : ($scoreBoardItem->getWin()+ 1 )));
			$scoreBoardItem2->setLose(($scoreBoardItem2->getLose() == null ? 1 : ($scoreBoardItem2->getLose()+ 1 )));
		}else if ($match->getHomeGoals() < $match->getAwayGoals())
		{
			//Deplasmanın Kazanması Durumu
			$scoreBoardItem2->setWin(($scoreBoardItem2->getWin() == null ? 1 : ($scoreBoardItem2->getWin()+ 1 )));
			$scoreBoardItem->setLose(($scoreBoardItem->getLose() == null ? 1 : ($scoreBoardItem->getLose()+ 1 )));
		}else //Beraberlik Durumu
		{
			$scoreBoardItem->setDraw(($scoreBoardItem->getDraw() == null ? 1 : ($scoreBoardItem->getDraw()+ 1 )));
			$scoreBoardItem2->setDraw(($scoreBoardItem2->getDraw() == null ? 1 : ($scoreBoardItem2->getDraw()+ 1 )));
		}

		//Oynanan maç sayısı 1 arttırılıyor.
		$scoreBoardItem->setPlayedMatch(($scoreBoardItem->getPlayedMatch() == null ? 1 : ($scoreBoardItem->getPlayedMatch()+ 1 )));
		$scoreBoardItem2->setPlayedMatch(($scoreBoardItem2->getPlayedMatch() == null ? 1 : ($scoreBoardItem2->getPlayedMatch()+ 1 )));

		//Ev Sahibi Takım İçin
		//Atılan gol sayısı toplanıyor
		$scoreBoardItem->setHomeGoals(
			($scoreBoardItem->getHomeGoals() == null ?
				$match->getHomeGoals() : 
				($scoreBoardItem->getHomeGoals()+ $match->getHomeGoals() )
			)
		);
		//Yenilen gol sayısı toplanıyor
		$scoreBoardItem->setAwayGoals(
			($scoreBoardItem->getAwayGoals() == null ?
				$match->getAwayGoals() :
				($scoreBoardItem->getAwayGoals()+ $match->getAwayGoals() )
			)
		);	

		//Deplasman Takım İçin
		//Atılan gol sayısı toplanıyor
		$scoreBoardItem2->setHomeGoals(
			($scoreBoardItem2->getHomeGoals() == null ?
				$match->getAwayGoals() : 
				($scoreBoardItem2->getHomeGoals()+ $match->getAwayGoals() )
			)
		);
		//Yenilen gol sayısı toplanıyor
		$scoreBoardItem2->setAwayGoals(
			($scoreBoardItem2->getAwayGoals() == null ?
				$match->getHomeGoals() :
				($scoreBoardItem2->getAwayGoals()+ $match->getHomeGoals() )
			)
		);	
		
		$entityManager->persist($scoreBoardItem);
		$entityManager->flush();
		$entityManager->persist($scoreBoardItem2);
		$entityManager->flush();
    }    
}
