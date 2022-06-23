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

    private function __construct(protected readonly Request $request      = new Request(),
                                 protected readonly RouteCollection $get  = new RouteCollection(),
                                 protected readonly RouteCollection $post = new RouteCollection(),
                                 protected string $method = '', protected array $args = [],
    )
    {}

    public function addNamedRoute(string $verb, string $route, string $method) : void
    {
        $this->{strtolower($verb)}->addElement(new Route($route, $method));
    }

    public function addAttributesController(array $controllerArray) : void
    {
        foreach ($controllerArray as $controller)
        {
            preg_replace('/\\\\/', '\\', $controller);
            $reflectionController = new \ReflectionClass($controller);
            foreach ($reflectionController->getMethods() as $method)
            {
                $attributes = $method->getAttributes(RouteAttribute::class);
                foreach ($attributes as $attribute)
                {
                    $route = $attribute->newInstance();
                }
            }
        }
    }

    public function run() : mixed
    {
        if (count($this->{strtolower($this->request->getRequestMethod())}) === 0)
        {
            throw new \InvalidArgumentException(message : '404 - Page not found.', code : 404);
        }
        foreach ($this->{strtolower($this->request->getRequestMethod())} as $key => $value)
        {
            if($value->verify($this->request->getCleanUri()))
            {
                $this->method = $value->getMethod();
                $this->args   = $value->getArgs();
                $temp = $this->prepareCallBack();
                call_user_func_array([new $temp[0], $temp[1]],$this->args);
                return true;
            }
        }
        throw new \InvalidArgumentException(message : '404 - Page not found.', code : 404);
    }

    private function prepareCallBack() : array
    {
        if(str_contains(haystack: $this->method, needle: '::'))
            return explode(separator: '::', string: $this->method);
        else
        {
            $temp = explode(separator: '\\', string: $this->method);
            $method = array_pop($temp);
            $class  = implode(separator: '\\', array: $temp);
            return [$class, $method];
        }

    }
}