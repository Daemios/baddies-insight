<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;

try {

    $data = (new Query())
        ->select()
        ->from('wow_members')
        ->where('main', '=', 1)
        ->join('wow_classes_specs', 'LEFT')
        ->on('wow_members.specialization_id', '=', 'wow_classes_specs.specialization_id')
        ->join('wow_classes', 'LEFT')
        ->on('wow_members.class_id', '=', 'wow_classes.class_id')
        ->orderBy('wow_class')
        ->execute();

    return new Response('OK', 'Retrieved mains', $data);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving mains');

}