<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\BossRosterPlayer;

try {

    // Find the player we're adding
    $data = (new Query())
        ->select()
        ->from('wow_bosses_roster')
        ->where('boss_id', '=', $_POST['boss_id'])
        ->where('week', '=', $_POST['week'])
        ->join('wow_members', 'LEFT')
        ->on('wow_bosses_roster.character_id', '=', 'wow_members.character_id')
        ->join('wow_classes_specs', 'LEFT')
        ->on('wow_members.specialization_id', '=', 'wow_classes_specs.specialization_id')
        ->join('wow_classes', 'LEFT')
        ->on('wow_members.class_id', '=', 'wow_classes.class_id')
        ->execute();

    return new Response('OK', 'Retrieved roster successfully', $data);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving roster');

}