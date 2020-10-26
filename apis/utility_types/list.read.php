<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'utility_id AS id',
            'label'
        ])
        ->from('wow_utility_types');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'label'
        ])
        ->sortMap([
            'utility_id' => 'id',
            'label' => 'label'
        ])
        ->execute();

    return new Response('OK', 'Retrieved sale pricing list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving sale pricing list');

}