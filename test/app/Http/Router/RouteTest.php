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
 *  RouteTest.php   June / 2022
 */

namespace GamerHelpDesk\Http\Router;

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @param $routes
     * @param $method
     * @return void
     * @dataProvider  routesDataProvider
     */
    public function testRegexCompiler($routes, $actualroute) : void
    {
        $route = new Route($routes, '  ');

        $this->assertTrue($route->verify($actualroute));
    }

    public function routesDataProvider() : array
    {
        return [
            ['home', 'home'],
            ['/acasa/:numeric/234/:string', '/acasa/54/234/mataSugePula'],
            [':alphanumeric', 'hf'],
            [':alphanumeric', '45'],
            [':alphanumeric', '45tyui']
        ];
    }

}
