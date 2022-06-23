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
 *  Registry.php   June / 2022
 */
declare(strict_types=1);

namespace GamerHelpDesk\Http\Helper;

/**
 * A registry class implementation, just a disguised global like variable class
 */
class Registry extends Collection
{

    use SingletonTrait;

    private function __construct(){}

    /**
     * @param $key
     * @param $value
     * @return void
     * Storing items
     */
    public function add($key, $value) : void
    {
        $this->collection[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     * Retrieving items, using array_key_exists because in_array doesn't work with array object from ArrayIterator,
     * we're using collection witch is an ArrayIterator instance
     */
    public function get($key) : mixed
    {
        if(!array_key_exists($key, $this->collection))
            throw new \InvalidArgumentException('Http Registry key is not set');
        return $this->collection[$key];
    }
}