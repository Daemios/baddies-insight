<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;

try {

    $data = (new Query())
        ->select(['boss_id', 'label'])
        ->where('instance_id', '=', $_POST['instance_id'])
        ->from('wow_bosses')
        ->execute(false, PDO::FETCH_KEY_PAIR);

    return new Response('OK', 'Retrieved boss data', $data);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving boss data');

}