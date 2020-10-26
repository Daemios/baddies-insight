<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;

try {

    $data = (new Query())
        ->select(['specialization_id', 'specialization'])
        ->where('class_id', '=', $_POST['class_id'])
        ->from('wow_classes_specs')
        ->execute(false, PDO::FETCH_KEY_PAIR);

    return new Response('OK', 'Retrieved wow specialization list', $data);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving wow specialization list');

}