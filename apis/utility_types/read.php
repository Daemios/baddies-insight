<?php

namespace DynamicSuite\Pkg\BaddiesInsight;

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudRead;
use Exception;
use PDO;

try {

    $data = (new Query())
        ->select()
        ->from('wow_utility_types')
        ->execute(false, PDO::FETCH_KEY_PAIR);


    return new Response('OK', 'Retrieved utility types', $data);

} catch (Exception $e) {

    return new Response('ERROR', 'Error retrieving utility types');

}