<?php
/**
 * API to read a storable by ID.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @package aui-crud-demo
 * @author Grant Martin <commgdog@gmail.com>
 * @copyright  2020 Dynamic Suite Team
 * @noinspection PhpUnused
 */

namespace DynamicSuite\Pkg\AuiCrudDemo;
use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\Aui\CrudPostValidation;
use DynamicSuite\Pkg\BaddiesInsight\Storable\ClassUtility;
use DynamicSuite\Pkg\BaddiesInsight\Storable\SalePrice;
use DynamicSuite\Pkg\BaddiesInsight\Storable\UtilityType;
use Exception;
use PDOException;

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
         * Map column names to specific names for the returned failures (if any).
         */
        ->prefixMap([
            'title' => 'Title'
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

    error_log(json_encode($_POST));

    /**
     * Update the storable.
     */
    $class_utility = new ClassUtility([
        'class_utility_id' => $_POST['class_utility_id'],
        'class_id' => $_POST['class_id'],
        'specialization_id' => $_POST['specialization_id'],
        'utility_id' => $_POST['utility_id'],
        'cooldown' => $_POST['cooldown'],
        'name' => $_POST['name']
    ]);

    try {
        $class_utility->update();
    } catch (Exception|PDOException $exception) {
        error_log($exception->getMessage());
        return new Response('SERVER_ERROR', 'A server error occurred while updating the class utility');
    }

    /**
     * Send a successful response.
     */
    return new Response('OK', 'Success');

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}