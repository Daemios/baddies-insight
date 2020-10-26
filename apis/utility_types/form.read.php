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
            'utility_id',
            'label'
        ])
        ->from('wow_utility_types')
        ->where('utility_id', '=', $_POST['id'])
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