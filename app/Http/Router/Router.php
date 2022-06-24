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

use GamerHelpDesk\Exception\GamerHelpDeskException;
use GamerHelpDesk\Exception\GamerHelpDeskExceptionEnum;
use GamerHelpDesk\Http\Helper\SingletonTrait;
use GamerHelpDesk\Http\Request\Request;
use ReflectionClass;
use ReflectionException;

/**
 * Simple class for routing
 * Named and Attribute routing
 */
class Router
{

    use SingletonTrait;

    /**
     * @param Request $request
     * @param RouteCollection $get
     * @param RouteCollection $post
     * @param string $method
     * @param array $args
     * Instantiate a lot of stuff
     */
    private function __construct(protected readonly Request $request      = new Request(),
                                 protected readonly RouteCollection $get  = new RouteCollection(),
                                 protected readonly RouteCollection $post = new RouteCollection(),
                                 protected string $method = '', protected array $args = [],
    )
    {}

    /**
     * @param string $verb
     * @param string $route
     * @param string $method
     * @return void
     * Traditional name based routing, doing some string manupulation to get $this{strl...} translate to
     * $this->get or $this->post witch are 2 storage/array's for HTTP verbs
     */
    public function addNamedRoute(string $verb, string $route, string $method) : void
    {
        $this->{strtolower($verb)}->addElement(new Route($route, ltrim($method, "\\")));
    }

    /**
     * @param array $controllerArray
     * @return void
     * @throws ReflectionException
     * Really basic attribute routing, we need to use Reflexion to get Attributes from methods
     * and a lot of foreach
     */
    public function addAttributesController(array $controllerArray) : void
    {
        foreach ($controllerArray as $controller)
        {
            preg_replace('/\\\\/', '\\', $controller);
            $reflectionController = new ReflectionClass($controller);
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

    /**
     * @return mixed
     * just routing
     * @throws GamerHelpDeskException
     */
    public function run() : bool
    {
        if (count($this->{strtolower($this->request->getRequestMethod())}) === 0)
        {
            throw new GamerHelpDeskException(GamerHelpDeskExceptionEnum::RouteNotFoundException);
        }
        foreach ($this->{strtolower($this->request->getRequestMethod())} as $key => $value)
        {
            if($value->verify($this->request->getCleanUri()))
            {
                $this->method = $value->getMethod();
                $this->args   = $value->getArgs();
                $temp = $this->prepareCallBack();
                if(!$this->checkMethod($temp))
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::InvalidArgumentException,
                                                    customMessage: "Class/method used for this route does not exist or is set to protected/private");
                }
                call_user_func_array([new $temp[0], $temp[1]],[$this->args]);
                return true;
            }
        }
        throw new GamerHelpDeskException(GamerHelpDeskExceptionEnum::RouteNotFoundException);
    }

    /**
     * @return array
     * Returning the storage/array's $this->get and $this->post
     * Both converted to array's from ArrayIterator instances
     */
    public function getRoutesArray() : array
    {
        return [iterator_to_array($this->get), iterator_to_array($this->post)];
    }

    /**
     * @return Request
     * Just return the request object
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * @return array
     * Searching for :: or \ to determine witch type of route we have, and depending on witch type
     * do some string manipulation and return an array containing the class and method in an array
     * We need it because of call_user_func_array
     */
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

    /**
     * Just a function to check if the method exist and is public
     * Short tldr is_callable doesn't see a normal method if the object is not instantiate, only static methods
     * method_exists doesn't care about access modifiers protected/private,
     * so this just a function to check if the method exists no matter if is normal or static and is public
     * @param array $classAndMethodArray
     * @return bool
     */
    private function checkMethod(array $classAndMethodArray) : bool
    {
        try
        {
            $reflection = new ReflectionClass("\\".$classAndMethodArray[0]);
            if($reflection->getMethod(name: $classAndMethodArray[1])->isPublic())
            {
                return true;
            }
        }
        catch (ReflectionException)
        {}
        return false;
    }
}