<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\Mia;

try {

    $calendar = [];

    // Generate the date containers
    for ($i = 0; $i < 28; $i++) {
        $date = date("m/d/Y", strtotime('+'. $i .' days'));
        $calendar[$date]['mias'] = [];
    }

    // Get the current MIAs
    $mias = (new Query())
        ->select()
        ->from('wow_bosses_roster_mia')
        ->where('date', '>=', strtotime('+'. 0 .' days'))
        ->join('wow_members', 'LEFT')
        ->on('wow_members.character_id', '=', 'wow_bosses_roster_mia.character_id')
        ->join('wow_classes_specs', 'LEFT')
        ->on('wow_members.specialization_id', '=', 'wow_classes_specs.specialization_id')
        ->join('wow_classes', 'LEFT')
        ->on('wow_members.class_id', '=', 'wow_classes.class_id')
        ->execute();

    // Map the mias to the containers
    foreach ($mias as $mia) {
        $key = date("m/d/Y", $mia['date']);
        $calendar[$key]['mias'][] = $mia;
    }


    return new Response('OK', 'Retrieved mains', $calendar);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving mains');

}