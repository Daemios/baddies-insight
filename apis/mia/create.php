<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\Mia;

try {

    $character = (new Query())
        ->select()
        ->from('wow_members')
        ->where('name', '=', $_POST['character'])
        ->execute(true);

    error_log(strtotime($_POST['date']));

    $mia = new Mia([
        'character_id' => $character['character_id'],
        'date'         => (new DateTime($_POST['date']))->format('U'),
        'duration'     => $_POST['duration'],
        'note'         => $_POST['note']
    ]);

    $mia->create();

    return new Response('OK', 'Retrieved mains', $mia);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving mains');

}