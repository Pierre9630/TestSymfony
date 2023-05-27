<?php

namespace App\Twig;

use App\Repository\OpeningHoursRepository;
use App\Twig\AppRuntime;
use Spatie\OpeningHours\OpeningHours;
use Symfony\Component\String\UnicodeString;
use Twig\Extension\AbstractExtension;
//use Twig\TwigFilter;
use Twig\TwigFunction;

class OpenHoursView extends AbstractExtension
{
    public function __construct(OpeningHoursRepository $OpeningHoursRepository )
    {
         $this->OpeningHoursRepo = $OpeningHoursRepository;
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('OpenHoursMethod',  [$this, 'getOpenHoursforWeek'], ['is_safe' => ['html']]),
            //new TwigFunction('OpenHoursMethod', [OpeningHours::class, 'OpenHoursMethod']),
        ];

    }
    public function getOpenHoursforWeek()
    {

        //$days = $this->TestDays();

        /*
        $openingHours = [];

        // Récupérer les horaires d'ouverture de la base de données
        $storeHours = $this->entityManager->getRepository(\App\Entity\OpeningHours::class)->findAll();

        // Parcourir les horaires d'ouverture
        foreach ($storeHours as $storeHour) {
            $dayOfWeek = intval($storeHour->getDays()); // Convertir le jour de la semaine en entier

            // Ajouter l'heure d'ouverture à l'heure de fermeture pour le jour de la semaine correspondant
            if (!isset($openingHours[$dayOfWeek])) {
                $openingHours[$dayOfWeek] = [];
            }

            $timeRange = $storeHour->getOpenTime() . ' - ' . $storeHour->getCloseTime(); // Créer une chaîne de temps

            if ($storeHour->getTimeOfDay() === 'midday') {
                $timeRange .= ' (midi)';
            } else {
                $timeRange .= ' (soir)';
            }

            $openingHours[$dayOfWeek][] = $timeRange;
        }

        // Déterminer le jour de la semaine actuel
        $currentDay = intval((new \DateTime())->format('N')) - 1;

        // Réorganiser le tableau pour commencer par le lundi
        $openingHours = array_merge(array_slice($openingHours, 1), array_slice($openingHours, 0, 1));

        // Déplacer le jour de la semaine actuel au début du tableau
        $openingHours = array_merge([$openingHours[$currentDay]], array_slice($openingHours, 0, $currentDay), array_slice($openingHours, $currentDay + 1));

        // Formater les horaires d'ouverture pour l'affichage dans le template Twig
        $formattedOpeningHours = [];

        foreach ($openingHours as $dayOfWeek => $timeRanges) {
            $formattedTimeRanges = [];

            foreach ($timeRanges as $timeRange) {
                $formattedTimeRanges[] = str_replace('-', ' à ', $timeRange);
            }

            $formattedOpeningHours[$this->weekdays[$dayOfWeek]] = implode(' / ', $formattedTimeRanges);
        }

        return $formattedOpeningHours;

        //dd($openingHours);*/
        return 0;

        //return $openingHours; //$openingHours->asStructuredData('H:iP', '+01:00'),
    }
    private function TestDays() : array
    {
        $sunday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 0, 'timeofday' => 'midday']);
        $sunday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 0, 'timeofday' => 'evening']);
        $monday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 1, 'timeofday' => 'midday']);
        $monday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 1, 'timeofday' => 'evening']);
        $tuesday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 2, 'timeofday' => 'midday']);
        $tuesday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 2, 'timeofday' => 'evening']);
        $wednesday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 3, 'timeofday' => 'midday']);
        $wednesday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 3, 'timeofday' => 'evening']);
        $thursday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 4, 'timeofday' => 'midday']);
        $thursday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 4, 'timeofday' => 'evening']);
        $friday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 5, 'timeofday' => 'midday']);
        $friday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 5, 'timeofday' => 'evening']);
        $saturday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 6, 'timeofday' => 'midday']);
        $saturday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 6, 'timeofday' => 'evening']);

        $days = '';
        $arraydays = [];
        $days .= '[';
        if($monday_morning  != null ){
            $days .= '\'monday\' => [' . $monday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $monday_morning->getCloseTime()->format('H:i');
        }
        if($monday_evening != null){
            $days .= ', ' . $monday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $monday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($tuesday_morning  != null ){
            $days .= '\'monday\' => [' . $tuesday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $tuesday_morning->getCloseTime()->format('H:i');
        }
        if($tuesday_evening != null){
            $days .= ', ' . $tuesday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $tuesday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($wednesday_morning  != null ){
            $days .= '\'monday\' => [' . $wednesday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $wednesday_morning->getCloseTime()->format('H:i');
        }
        if($wednesday_evening != null){
            $days .= ', ' . $wednesday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $wednesday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($thursday_morning  != null ){
            $days .= '\'monday\' => [' . $thursday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $thursday_morning->getCloseTime()->format('H:i');
        }
        if($thursday_evening != null){
            $days .= ', ' . $thursday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $thursday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($friday_morning  != null ){
            $days .= '\'monday\' => [' . $friday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $friday_morning->getCloseTime()->format('H:i');
        }
        if($friday_evening != null){
            $days .= ', ' . $friday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $friday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($saturday_morning  != null ){
            $days .= '\'monday\' => [' . $saturday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $saturday_morning->getCloseTime()->format('H:i');
        }
        if($saturday_evening != null){
            $days .= ', ' . $saturday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $saturday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        if($sunday_morning  != null ){
            $days .= '\'monday\' => [' . $sunday_morning->getOpenTime()->format('H:i') . ' .\'-\' . ' .  $sunday_morning->getCloseTime()->format('H:i');
        }
        if($sunday_evening != null){
            $days .= ', ' . $sunday_evening->getOpenTime()->format('H:i') . ' .\'-\' . ' . $sunday_evening->getCloseTime()->format('H:i') .'],';
        }else{
            $days .='],';
        }

        $days .= ']';

        array_push($arraydays, $days);
        //dd($arraydays[0]);
        return $arraydays;
    }
}