<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Moviemon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Service\OmdbApiService;


class FightController extends AbstractController
{
    #[Route('/fight', name: 'app_fight')]
    public function index(Request $request, OmdbApiService $omdbApiService): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User)
            return $this->redirectToRoute('homepage');
        $moviemon = $omdbApiService->getMoviemonById($request->query->get('moviemon_id'));
        if (!$moviemon instanceof Moviemon)
        {
            logger()->error('Moviemon not found', ['moviemon_id' => $request->query->get('moviemon_id')]);
            $this->addFlash('error', 'Moviemon not found');
            return $this->redirectToRoute('overworld');
        }
        return $this->render('fight.html.twig', [
            'user' => $user,
            'moviemon' => $moviemon
        ]);
    }
}