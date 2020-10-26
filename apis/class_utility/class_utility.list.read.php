<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'class_utility_id AS id',
            'class_id',
            'utility_id',
            'cooldown'
        ])
        ->from('wow_classes_utility');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'class_id',
            'utility_id'
        ])
        ->sortMap([
            'class_id' => 'class_id',
            'utility_id' => 'utility_id',
            'cooldown' => 'cooldown'
        ])
        ->execute();

    return new Response('OK', 'Retrieved wow class utility list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving wow class utility list');

}