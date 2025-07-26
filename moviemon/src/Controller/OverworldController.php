<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// including the Game Manager service
use App\Service\GameManager;

class OverworldController extends AbstractController
{
    //TODO: aggiungere grandezza della mappa al game manager
    #[Route('/new', name: 'new')]
    public function StartNewGame(GameManager $gameManager)
    {
        $gameManager->StartNewGame("testUser");
        $user = $gameManager->getUser();
        $position = array(2, 3);
        $user->setPosition($position);
        return $this->redirectToRoute('overworld');
    }

    #[Route('/overworld', name: 'overworld')]
    public function index(GameManager $gameManager): Response
    {
        $map = $this->generateMap($gameManager);
        $toCatch = $this->getRemainingMovies($gameManager);
        $catched = $this->getCatchedMovies($gameManager);
        return $this->render('map.html.twig', [
            'map' => $map,
            'catchable' => $toCatch,
            'catched' => $catched,
        ]);
    }

    public function getRemainingMovies(GameManager $gameManager): array
    {
        $user = $gameManager->getUser();
        // var_dump($user->getRemainingMoviemons());
        $entities = $user->getRemainingMoviemons();
        $remaining = [];

        foreach ($entities as $movie)
        {
            $remaining[] = $movie->getName();
        }
        // print_r($remaining);
        return($remaining);
    }

        public function getCatchedMovies(GameManager $gameManager): array
    {
        $user = $gameManager->getUser();
        // var_dump($user->getRemainingMoviemons());
        $entities = $user->getCapturedMoviemons();
        $remaining = [];

        foreach ($entities as $movie)
        {
            $remaining[] = $movie->getName();
        }
        // print_r($remaining);
        return($remaining);
    }


    public function generateMap(GameManager $gameManager)
    {
        $grid = [];

        $rows = 5;
        $columns = 5;

        $user = $gameManager->getUser();
        $playerPosition = $user->getPosition();

        for ($y = 0; $y < $columns; $y++) {
            $row = [];
            for ($x = 0; $x < $rows; $x++) {
                $row[] = " ";
            }
            $grid[] = $row;
        }

        $grid[$playerPosition[0]][$playerPosition[1]] = 'P';

        return ($grid);
    }

}

?>