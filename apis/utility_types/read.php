<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;

try {

    $data = (new Query())
        ->select()
        ->from('wow_utility_types')
        ->execute();


    return new Response('OK', 'Retrieved utility types', $data);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving utility types');

}