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
        return $this->render('map.html.twig', [
            'map' => $map,
        ]);
    }

    public function generateMap(GameManager $gameManager)
    {
        $grid = [];

        $rows = 5;
        $columns = 5;

        $user = $gameManager->getUser();

        // var_dump($user);

        // finding center of the map
        // $playerX = (int) floor($rows / 2);
        // $playerY = (int) floor($columns / 2);

        // $playerPosition = [$playerX, $playerY];
        $playerPosition = $user->getPosition();

        // debug
        // echo "player X: " . $playerPosition[0] . "  player Y: " . $playerPosition[1];

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