<?php
/**
 * Copyright (C) 2022  M. Dumitru Daniel (aka danutz0501)
 * This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published
 *   by the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *    You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  bootstrap.php   June / 2022
 */
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('xdebug.var_display_max_depth','15');
ini_set('xdebug.var_display_max_children','256');
ini_set('xdebug.var_display_max_data','1024');

date_default_timezone_set("Europe/Bucharest");
mb_internal_encoding("UTF-8");

define("BASE_PATH", realpath(__DIR__).DIRECTORY_SEPARATOR);
const COMPOSER_PATH      = BASE_PATH."vendor".DIRECTORY_SEPARATOR;
const PYTHON_PATH        = BASE_PATH."python".DIRECTORY_SEPARATOR;
const CONFIGURATION_PATH = BASE_PATH."config".DIRECTORY_SEPARATOR;

try
{
    if(file_exists(COMPOSER_PATH.'autoload.php') && is_readable(COMPOSER_PATH.'autoload.php'))
    {
        require_once COMPOSER_PATH.'autoload.php';
        $router = \GamerHelpDesk\Http\Router\Router::init();
        $router->addAttributesController(['Stream\\Stream']);
        $router->addNamedRoute(verb: 'get', route: '/', method: 'Internal\\Home\\index');
        $router->addNamedRoute(verb: 'get', route: '/notes', method: 'Internal\\Home\\notes');
        /**
         * Added {#note :numeric} for regexp capture, the array for calling the function is an associative array.
         * The array pushed to the method looks like this ['note' => '45']
         * {#name for var a space :numeric}
         */
        $router->addNamedRoute(verb: 'get', route: '/notes/{#note :numeric}', method: 'Internal\\Home\\readNote');
        $router->run();
    }
    else
    {
        throw new InvalidArgumentException(message: "Composer autoloader not found or cannot be loaded.", code: 0);
    }
}
catch (Throwable $exception)
{
    echo $exception->getMessage();
}