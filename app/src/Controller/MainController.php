<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TeamCreateFormType;
use App\Entity\Team;
use App\Entity\FootballMatch;
use App\Entity\ScoreBoard;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/{page}", name="main", requirements={"page"="\d+"})
     */
    public function index($page=1)
    {
        $teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $isEmpty = $this->getDoctrine()->getRepository(FootballMatch::class)
            ->count(['week' => 1]);
        $matches = $this->getDoctrine()->getRepository(FootballMatch::class)
            ->findBy(['week' => $page]);

        if ($isEmpty == 0)
        {            
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'teams' => $teams,
                'teamsCount' => count($teams),
                'fixture' => false
            ]);              
        }else
        {    
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'fixture' => true,
                'matches' => $matches,
                'page' => $page
            ]);       
        }
    }
    /**
     * @Route("/teamCreate", name="teamCreate")
     */
    public function teamCreate()
    {
        /* Daha iyi bir yöntem var mı araştır*/
        $teamCount = count($this->getDoctrine()->getRepository(Team::class)->findAll());
        if ($teamCount == 18)
        {
            return $this->redirectToRoute('main');
        }

        $teamCreateForm = $this->createForm(TeamCreateFormType::class);
        return $this->render('main/createTeam.html.twig', [
            'controller_name' => 'MainController',
            'teamCreateForm' => $teamCreateForm->createView()
        ]);
    }

    /**
     * @Route("/teamCreateProcess", name="teamCreateProcess")
     */
    public function teamCreateProcess(Request $req)
    {
        /* Daha iyi bir yöntem var mı araştır*/
        $teamCount = count($this->getDoctrine()->getRepository(Team::class)->findAll());
        if ($teamCount == 18)
        {
            return $this->redirectToRoute('main');
        }

        $teamCreateForm = $this->createForm(TeamCreateFormType::class);
        $teamCreateForm->handleRequest($req);

        if($teamCreateForm->isSubmitted())
        {
            $data = $teamCreateForm->getData();
            $team = new Team();
            $team->setName($data['teamName']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/fixtureCreate", name="fixtureCreate")
     */    
    public function fixtureCreate()
    { 
		$teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $entityManager = $this->getDoctrine()->getManager();         
		$rounds = array();
        $round = array();
		
		foreach($teams as $team)
		{
			array_push($round, $team->getId());
		}	
		
		//ilk roundu kaydettik
		array_push($rounds, $round);
		
		//17 Haftalık round'u ayarladık
		for ($i=1; $i<17; $i++)
		{
			$tmp = array();
			//ilk eleman sabit
			$tmp[0] = $round[0];
			//2. eleman son eleman
			$tmp[1] = end($round);
			//Diğer elemanlar bir birim yer değiştiriyor
			for ($j=1; $j < count($round)-1 ; $j++)
			{
				$tmp[$j+1] = $round[$j];
			}			
			$round = $tmp;
			array_push($rounds, $round);
		}

		//Round id'lerine göre iç saha takımları atanıyor
		$week = 1;
		foreach ($rounds as $r)
		{
			for ($k=0; $k<9; $k++)
			{
				$homeId = $r[$k];
				$awayId = $r[17-$k];
				
				$home = $this->getDoctrine()->getRepository(Team::class)->findBy(['id' => $homeId ]);
				$away = $this->getDoctrine()->getRepository(Team::class)->findBy(['id' => $awayId ]);
				
				$match = new FootballMatch();
				$match->setHome($home[0]);
				$match->setAway($away[0]);
				$match->setState(false);
				$match->setWeek($week);
				
				$entityManager->persist($match);				
			}			
			$week++;
		}
		
		//Deplasman takımları atanıyor
		foreach ($rounds as $r)
		{
			for ($k=0; $k<9; $k++)
			{
				$homeId = $r[17-$k];
				$awayId = $r[$k];
				
				$home = $this->getDoctrine()->getRepository(Team::class)->findBy(['id' => $homeId ]);
				$away = $this->getDoctrine()->getRepository(Team::class)->findBy(['id' => $awayId ]);
				
				$match = new FootballMatch();
				$match->setHome($home[0]);
				$match->setAway($away[0]);
				$match->setState(false);
				$match->setWeek($week);
				
				$entityManager->persist($match);				
			}			
			$week++;
		}
				
		$entityManager->flush();		
        return $this->redirectToRoute('main');	
	}

    /**
    * @Route("/play/{week}", name="play")
    */
    public function play($week)
    {
        $matches = $this->getDoctrine()->getRepository(FootballMatch::class)
                   ->findBy(['week' => $week]);   
        $entityManager = $this->getDoctrine()->getManager();

        foreach ($matches as $match)
        {
            if ($match->getState() == false)
            {
                $match->setHomeGoals(rand(0, 6));
                $match->setAwayGoals(rand(0, 6));
                $match->setState(true);
                $entityManager->persist($match);
				$entityManager->flush();
            }
        }
        return $this->redirectToRoute('main', array('page'=> $week));      
    }
	
    /**
    * @Route("/scoreboard", name="scoreboard")
    */
    public function scoreboard()
    {
		$scores = $this->getDoctrine()->getRepository(ScoreBoard::class)
                   ->findBy([], ['rank' => 'ASC']);  
        return $this->render('main/scoreBoard.html.twig', [
            'controller_name' => 'MainController',
            'scores' => $scores
        ]);		
	}		

    /**
    * @Route("/deleteAllData", name="delete")
    */
    public function deleteAllData()
    {
		$matches = $this->getDoctrine()->getRepository(FootballMatch::class)->findAll();
		$scores = $this->getDoctrine()->getRepository(ScoreBoard::class)->findAll();
		$teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
		
		$entityManager = $this->getDoctrine()->getManager();
		
		foreach ($matches as $match)
		{
			$entityManager->remove($match);
			$entityManager->flush();
		}
		
		foreach ($scores as $score)
		{
			$entityManager->remove($score);
			$entityManager->flush();
		}
		
		foreach ($teams as $team)
		{
			$entityManager->remove($team);
			$entityManager->flush();
		}		

		return $this->redirectToRoute('main'); 
	}		

    /**
    * @Route("/defaultTeams", name="defaultTeams")
    */
    public function defaultTeams()
    {
		$entityManager = $this->getDoctrine()->getManager();
		$teamNames = array(
					'Galatasaray',
					'Fenerbahçe',
					'Gaziantep Spor',
					'Adana Spor',
					'Gençlerbirliği',
					'Trabzon Spor',
					'Kasımpaşa',
					'Akhisar',
					'Erzurum Spor',
					'Sivas Spor',
					'Çaykur Rize',
					'Malatya Spor',
					'Göztepe',
					'Konya Spor',
					'Antalya Spor',
					'Ankara Gücü',
					'Bursa Spor',
					'Alanya Spor',
				);
		
		$teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
		foreach ($teams as $team)
		{
			$entityManager->remove($team);
			$entityManager->flush();
		}	
		
		for ($i=0; $i<count($teamNames); $i++)
		{
			$team = new Team();
			$team->setName($teamNames[$i]);		
			$entityManager->persist($team);
			$entityManager->flush();			
		}
		
		return $this->redirectToRoute('main'); 
	}

}
