<?php
namespace DynamicSuite\Pkg\BaddiesInsight;
use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use Exception;

try {

    /**
     * Read the storable.
     */
    $storable = (new Query())
        ->select([
            'character_id',
            'name',
            'class_id',
            'specialization_id'
        ])
        ->from('wow_members')
        ->where('character_id', '=', $_POST['id'])
        ->execute(true);

    /**
     * Return the storable, or some other error.
     */
    if (!$storable) {
        return new Response('NOT_FOUND', 'Storable not found');
    } else {
        return new Response('OK', 'Success', $storable);
    }

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}