<?php

namespace App\Twig;

use App\Twig\AppRuntime;
use Spatie\OpeningHours\OpeningHours;
use Twig\Extension\AbstractExtension;
//use Twig\TwigFilter;
use Twig\TwigFunction;

class OpenHoursView extends AbstractExtension
{
    public function getFunctions() : array
    {
        return [
            new TwigFunction('OpenHoursMethod',  [$this, 'getOpenHoursforWeek'], ['is_safe' => ['html']]),
            //new TwigFunction('OpenHoursMethod', [OpeningHours::class, 'OpenHoursMethod']),
        ];

    }
    public function getOpenHoursforWeek(OpeningHoursRepository $OpeningHoursRepository)
    {

        $openingHours = OpeningHours::create([
            'monday' => [$OpeningHoursRepository->findBy(), '19:00-22:00'],
            'tuesday' => ['12:00-14:00', '19:00-22:00'],
            'thursday' => ['12:00-14:00', '19:00-22:00'],
            'friday' => ['12:00-14:00', '19:00-21:00'],
            'saturday' => ['12:00-14:00', '19:00-22:00'],
            'sunday' => ['12:00-14:00'],
        ]);

        return $openingHours->forWeek(); //$openingHours->asStructuredData('H:iP', '+01:00'),
    }
}