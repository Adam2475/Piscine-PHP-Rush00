<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OverworldController extends AbstractController
{

    #[Route('/overworld', name: 'overworld')]
    public function index(): Response
    {
        $map = $this->generateMap();
        return $this->render('map.html.twig', [
            'map' => $map,
        ]);
    }

    public function generateMap()
    {
        $grid = [];

        $rows = 5;
        $columns = 5;

        for ($y = 0; $y < $columns; $y++) {
            $row = [];
            for ($x = 0; $x < $rows; $x++) {
                $row[] = "[$x,$y]";
            }
            $grid[] = $row;
        }

        return ($grid);
    }

}

?>