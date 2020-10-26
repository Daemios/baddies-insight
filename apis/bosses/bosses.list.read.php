<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'boss_id AS id',
            'label',
            'instance_id'
        ])
        ->from('wow_bosses');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'label',
            'instance_id'
        ])
        ->sortMap([
            'boss_id' => 'id',
            'label' => 'label',
            'instance_id' => 'instance_id'
        ])
        ->execute();

    return new Response('OK', 'Retrieved boss list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving boss list');

}