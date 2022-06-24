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
 *  GamerHelpDeskException.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Exception;

use Exception;

/**
 * Some custom exception's
 */
class GamerHelpDeskException extends Exception
{

    /**
     * @throws Exception
     */
    public function __construct(private readonly GamerHelpDeskExceptionEnum $case, private readonly string $customMessage = '')
    {
        /** @noinspection PhpExpressionResultUnusedInspection */
        match ($this->case)
        {
            GamerHelpDeskExceptionEnum::InvalidArgumentException => parent::__construct(message: sprintf("BAD REQUEST - INVALID ARGUMENT %s" , $this->customMessage)),
            GamerHelpDeskExceptionEnum::RangeException           => parent::__construct(message: sprintf("BAD REQUEST - RANGE %s"            , $this->customMessage)),
            GamerHelpDeskExceptionEnum::InvalidClassException    => parent::__construct(message: sprintf( "BAD REQUEST - INVALID CLASS %s"   , $this->customMessage)),
            GamerHelpDeskExceptionEnum::InvalidMethodException   => parent::__construct(message: sprintf( "BAD REQUEST - INVALID METHOD %s"  , $this->customMessage)),
            GamerHelpDeskExceptionEnum::InvalidPropertyException => parent::__construct(message: sprintf( "BAD REQUEST - INVALID PROPERTY %s", $this->customMessage)),
            GamerHelpDeskExceptionEnum::RouteNotFoundException   => parent::__construct(message: "Route not found", code: 404),
        };
    }
}