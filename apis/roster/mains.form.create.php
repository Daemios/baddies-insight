<?php
namespace DynamicSuite\Pkg\BaddiesInsight;
use DynamicSuite\API\Response;
use DynamicSuite\Pkg\Aui\CrudPostValidation;
use DynamicSuite\Pkg\BaddiesInsight\Storable\Member;
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
            'name' => 50
        ])
        /**
         * Validate the minimum lengths.
         */
        ->minimums([
            'name' => 2
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
    $member = new Member([
        'name' => $_POST['name'],
        'class_id' => $_POST['class_id'],
        'specialization_id' => $_POST['specialization_id'],
        'main' => 1
    ]);

    $member->create();

    /**
     * Must return the new storable ID as the data payload.
     */
    return new Response('OK', 'Success', $member->character_id);

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}