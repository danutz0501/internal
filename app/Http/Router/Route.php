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
 *  Route.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Router;

/**
 * An object used in routing
 */
class Route
{

    /**
     * @var array|string[]
     * An array of key and values used for matching with regular expressions
     */
    private array $patterns = [
        ':string'       => '([a-z\-]+)',
        ':numeric'      => '(\d+)',
        ':alphanumeric' => '(\w+\-)',
        '{'             => '(',
        '}'             => ')',
        '#'             => '?<',
        ' '             => '>',
    ];

    public function __construct(private readonly string $regexToCompile, private readonly string $method,
                                private string $regex = '', private array $args = [])
    {
        $this->compileRegex($this->regexToCompile);
    }

    /**
     * @param $input
     * @return bool
     * Verify/match if the input given is matching the stored route, like:
     * example.com/user/45/blog-post/bla match with this example.com/user/:digit/blog-post/:alphanumeric
     */
    public function verify($input) : bool
    {
        if(preg_match($this->regex, $input, $out))
        {
            $this->args = $out;
            return true;
        }
        return false;
    }

    /**
     * @return void
     * Replacing the tokens used in routes with regular expression
     * :digit with /^(\d+)$/i
     */
    private function compileRegex() : void
    {
        $this->regex = "/^".str_replace("/", "\/",$this->regexToCompile)."$/i";
        $this->regex = str_replace(array_keys($this->patterns), array_values($this->patterns), $this->regex);
    }

    /**
     * @return string
     * returns the method for the route
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @return array
     * Returns an array, first element is the entire match, subsequently elements of the array are the match parts
     * array[0] - is the whole match expression, array[1], array[2] etc are the match parts used for arguments in methods/function calls
     */
    public function getArgs() : array
    {
        return $this->args;
    }
}