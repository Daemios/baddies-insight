<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'instance_id AS id',
            'type',
            'label',
            'tier'
        ])
        ->from('wow_instances');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'type',
            'label',
            'tier'
        ])
        ->sortMap([
            'instance_id' => 'id',
            'type' => 'type',
            'label' => 'label',
            'tier' => 'tier'
        ])
        ->execute();

    return new Response('OK', 'Retrieved instance list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving instance list');

}