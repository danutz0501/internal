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

class Route
{

    private array $patterns = [
        ':string' => '([a-z\-]+)',
        ':numeric' => '(\d+)',
        ':alphanumeric' => '(\w+)'
    ];

    public function __construct(private readonly mixed $regexToCompile, private readonly string $method,
                                private string $regex = '', private array $args = [])
    {
        $this->compileRegex($this->regexToCompile);
    }

    public function verify($input) : bool
    {
        if(preg_match($this->regex, $input, $out))
        {
            $this->args = $out;
            return true;
        }
        return false;
    }
    private function compileRegex() : void
    {
        $this->regex = "/^".str_replace("/", "\/".$this->regex)."$/i";
        $this->regex = str_replace(array_keys($this->patterns), array_values($this->patterns));
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getArgs() : array
    {
        return $this->args;
    }
}