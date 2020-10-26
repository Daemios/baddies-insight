<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'character_id AS id',
            'name',
            'class_id',
            'specialization_id'
        ])
        ->from('wow_members');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'name',
            'class_id',
            'specialization_id'
        ])
        ->sortMap([
            'name' => 'name',
            'class_id' => 'class_id',
            'specialization_id' => 'specialization_id'
        ])
        ->execute();

    return new Response('OK', 'Retrieved main character list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving main character list');

}