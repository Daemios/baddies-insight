<?php
namespace DynamicSuite\Pkg\BaddiesInsight;
use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudPostValidation;
use DynamicSuite\Pkg\BaddiesInsight\Storable\ClassUtility;
use DynamicSuite\Pkg\BaddiesInsight\Storable\SalePrice;
use DynamicSuite\Pkg\BaddiesInsight\Storable\UtilityType;
use Exception;

try {

    error_log(json_encode($_POST));

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
    $utility_type = new ClassUtility([
        'class_id' => $_POST['class_id'],
        'specialization_id' => $_POST['specialization_id'],
        'utility_id' => $_POST['utility_id'],
        'cooldown' => $_POST['cooldown'],
        'name' => $_POST['name']
    ]);

    $utility_type->create();

    /**
     * Must return the new storable ID as the data payload.
     */
    return new Response('OK', 'Success', $utility_type->utility_id);

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}