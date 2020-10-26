<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\BossRosterPlayer;

try {

    error_log(json_encode($_POST));

    $boss_roster_player_replacement = new BossRosterPlayer([
        'boss_id'   => $_POST['boss_id'],
        'character_id' => $_POST['character_id'],
        'week'      => $_POST['week']
    ]);

    $boss_roster_player_replacement->delete();

    return new Response('OK', 'Removed');

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error editing roster');

}