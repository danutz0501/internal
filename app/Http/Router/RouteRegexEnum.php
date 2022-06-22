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
 *  RouteRegexEnum.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Router;

enum RouteRegexEnum : int
{
    case STRING       =1;
    case NUMERIC      = 2;
    case ALPHANUMERIC = 3;

    public static function regex(RouteRegexEnum $param) : string
    {
        return match ($param)
        {
            RouteRegexEnum::STRING       => ':string',
            RouteRegexEnum::NUMERIC      => ':numeric',
            RouteRegexEnum::ALPHANUMERIC => ':alphanumeric',
        };
    }
}