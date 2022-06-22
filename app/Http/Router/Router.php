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
 *  Router.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Router;

use GamerHelpDesk\Http\Helper\SingletonTrait;
use GamerHelpDesk\Http\Request\Request;

class Router
{

    use SingletonTrait;

    private function __construct(protected readonly object $request = new Request(),
                                protected RouteCollection $get = new RouteCollection(),
                                protected RouteCollection $post = new RouteCollection()
    )
    {}

    public function addNamedRoute(string $verb, string $route, string $method) : void
    {
        $this->{strtolower($verb)}->addElement(new Route($route, $method));
    }

    public function addAttributesController() : void
    {

    }

    public function run() : mixed
    {
        if (count($this->{strtolower($this->request->getRequestMethod())}) === 0)
        {
            throw new \InvalidArgumentException('404 - Page not found.');
        }
        foreach ($this->{strtolower($this->request->getRequestMethod())} as $key => $value)
        {
            if($value->match($this->request->getCleanUri()))
            {
                return true;
            }
        }
        throw new \HttpRequestException('404 - Page not found.');
    }
}