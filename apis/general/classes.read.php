<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;

try {

    $data = (new Query())
        ->select(['class_id', 'wow_class'])
        ->from('wow_classes')
        ->execute(false, PDO::FETCH_KEY_PAIR);

    return new Response('OK', 'Retrieved wow class list', $data);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving wow class list');

}