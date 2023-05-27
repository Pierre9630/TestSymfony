<?php

namespace App\Controller;

use App\Entity\OpeningHours;
use App\Repository\OpeningHoursRepository;
use App\Service\ResSlots;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/API', name: 'app_API')]
    public function index(Request $req, EntityManagerInterface $em, ResSlots $resSlots): JsonResponse
    {
        $body = $req->getContent();

            //dd($req->query->get('nbcutelry'));
            //dd($req->query->get('date'));
        $slots= $resSlots->getAvailableTimeSlots($em,Carbon::createFromFormat('Y-m-d H:i:s',$req->query->get('date')), intval($req->query->get('nbcutelry'))); //Carbon::createFromFormat('Y-m-d',$req->query->get('date'))

        return new JsonResponse([
            'slots' => $slots,
        ]);
    }
}
