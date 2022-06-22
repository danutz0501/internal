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
 *  Stream.php   June / 2022
 */
declare(strict_types=1);
namespace Stream;

use GamerHelpDesk\Http\Router\Route;
use GamerHelpDesk\Http\Router\RouteAttribute;

class Stream
{

    #[RouteAttribute('get', '/stream/home', 'Stream\\Stream')]
    public function home()
    {
        echo 'merge din home';
    }
}