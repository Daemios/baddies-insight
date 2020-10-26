<?php
namespace DynamicSuite\Pkg\BaddiesInsight;
use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudPostValidation;
use DynamicSuite\Pkg\BaddiesInsight\Storable\WowInstance;
use Exception;

try {

    /**
     * Validate for length errors in the given data.
     */
    $errors = (new CrudPostValidation())
        /**
         * Validate the maximum lengths.
         */
        ->limits([
            'label' => 50
        ])
        /**
         * Validate the minimum lengths.
         */
        ->minimums([
            'label' => 2
        ])
        /**
         * Run the validation.
         */
        ->validate();

    /**
     * If there are errors.
     *
     * Must return INPUT_ERROR with the $errors as the validated errors.
     */
    if ($errors) {
        return new Response('INPUT_ERROR', 'Input validation error', $errors);
    }

    /**
     * Add the storable
     */
    $instance = new WowInstance([
        'type' => $_POST['type'],
        'label' => $_POST['label'],
        'tier' => $_POST['tier']
    ]);

    $instance->create();

    /**
     * Must return the new storable ID as the data payload.
     */
    return new Response('OK', 'Success', $instance->instance_id);

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}