<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;

try {

    $data = (new Query())
        ->select([
            'instance_id',
            'label'
        ])
        ->from('wow_instances')
        ->execute(false, PDO::FETCH_KEY_PAIR);

    return new Response('OK', 'Retrieved wow instances', $data);

} catch (Exception | PDOException $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving wow instances');

}