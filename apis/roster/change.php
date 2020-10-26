<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\BossRosterPlayer;

try {

    // Find the player we're adding
    $player = (new Query())
        ->select()
        ->from('wow_members')
        ->where('name', '=', $_POST['player'])
        ->execute(true);

    // Instantiate the storable for that player
    $boss_roster_player = new BossRosterPlayer([
        'boss_id'   => $_POST['boss'],
        'character_id' => $player['character_id'],
        'week'      => $_POST['week']
    ]);

    // Handle the deletion of any player we're replacing with the same general method
    if ( isset($_POST['replace']) ) {

        $replaced = (new Query())
            ->select()
            ->from('wow_members')
            ->where('name', '=', $_POST['replace'])
            ->execute(true);

        $boss_roster_player_replacement = new BossRosterPlayer([
            'boss_id'   => $_POST['boss'],
            'character_id' => $replaced['character_id'],
            'week'      => $_POST['week']
        ]);

        $boss_roster_player_replacement->delete();
    }

    // Create a new entry
    $id_created = $boss_roster_player->create();

    return new Response('OK', $_POST['player'], $id_created);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error editing roster');

}