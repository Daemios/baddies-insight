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
use DynamicSuite\Pkg\Aui\CrudPostValidation;
use DynamicSuite\Pkg\BaddiesInsight\Storable\Member;
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
     * Update the storable.
     */
    $member = new Member([
        'sale_price_id' => $_POST['character_id'],
        'name' => $_POST['name'],
        'class_id' => $_POST['class_id'],
        'specialization_id' => $_POST['specialization_id']
    ]);

    error_log(json_encode($_POST));

    try {
        $member->update();
    } catch (Exception|PDOException $exception) {
        error_log($exception->getMessage());
        return new Response('SERVER_ERROR', 'A server error occurred while updating the sale price');
    }

    /**
     * Send a successful response.
     */
    return new Response('OK', 'Success');

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}