<?php

namespace App\Controller;

use Carbon\Carbon;
use Carbon\Doctrine\DateTimeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Spatie\OpeningHours\OpeningHours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ResSlots;



class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',

        ]);

    }

    #[Route('/res', name: 'app_res')]
    public function res(EntityManagerInterface $em, ResSlots $resslots,  $date = 0): Response
    {

        //dd(\DateTime::createFromFormat('Y-m-d H:i:s','2023-05-02 00:00:00'));
        //dd($date);
        
        //$finaldate = $date->format('Y-m-d');
        //dd($finaldate);

        $numberslots = $resslots->getAvailableTimeSlots($em,Carbon::now(),2);
        //dd($numberslots);
        $openingHours = OpeningHours::create([
            'monday' => ['12:00-14:00', '19:00-22:00'],
            'tuesday' => ['12:00-14:00', '19:00-22:00'],
            'thursday' => ['12:00-14:00', '19:00-22:00'],
            'friday' => ['12:00-14:00', '19:00-21:00'],
            'saturday' => ['12:00-14:00', '19:00-22:00'],
            'sunday' => ['12:00-14:00'],
        ]);
        /*$test = [
            0 => [
                 'monday' => '12:00-14:00'
            ],
            1 =>['12:30-13:30'],
        ];
        $people = array(
            2 => array(
                'name' => 'John',
                'fav_color' => 'green',
                'date' => '02-05-2026',
            ),
            5=> array(
                'name' => 'Samuel',
                'fav_color' => 'blue'
            )
        );
        dd($people);*/

        return $this->render('index/reservation.html.twig', [
            'controller_name' => 'IndexController',
            'resslots' => $numberslots,

            //dd($openingHours->forWeek()),
        ]);
    }



}
