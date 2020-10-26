<?php
/**
 * API to delete a storable.
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
use Exception;

try {

    /**
     * Delete the storable
     */
   (new Query())
        ->delete()
        ->from('wow_utility_types')
        ->where('utility_id', '=', $_POST['utility_id'])
        ->execute();

    /**
     * Just return OK
     */
    return new Response('OK', 'Success');

} catch (Exception $exception) {
    error_log($exception->getMessage());
    return new Response('SERVER_ERROR', 'A server error has occurred');
}