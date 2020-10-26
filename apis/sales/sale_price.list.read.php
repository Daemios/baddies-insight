<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $query = (new Query())
        ->select([
            'sale_price_id AS id',
            'label AS title',
            'price AS subtext',
            'type'
        ])
        ->from('sale_pricing');

    $crud = (new CrudRead($query))
        ->searchColumns([
            'label',
            'price',
            'type'
        ])
        ->sortMap([
            'sale_price_id' => 'id',
            'label' => 'title',
            'price' => 'subtext',
            'type' => 'type'
        ])
        ->execute();

    return new Response('OK', 'Retrieved sale pricing list', $crud);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving sale pricing list');

}