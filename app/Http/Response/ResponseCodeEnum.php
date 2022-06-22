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
 *  ResponseCodeEnum.php   June / 2022
 */
declare(strict_types=1);

namespace GamerHelpDesk\Http\Response;

enum ResponseCodeEnum : int
{
    case CONTINUE              = 100;
    case OK                    = 200;
    case MOVED_PERMANENTLY     = 301;
    case BAD_REQUEST           = 400;
    case ACCESS_DENIED         = 403;
    case NOT_FOUND             = 404;
    case REQUEST_URI_TOO_LONG  = 414;
    case INTERNAL_SERVER_ERROR = 500;
    case SERVICE_UNAVAILABLE   = 503;

    public static function getLabel(ResponseCodeEnum $param) : string
    {
        return match ($param)
        {
            ResponseCodeEnum::CONTINUE              => 'Continue',
            ResponseCodeEnum::OK                    => 'OK',
            ResponseCodeEnum::MOVED_PERMANENTLY     => 'Moved Permanently',
            ResponseCodeEnum::BAD_REQUEST           => 'Bad Request',
            ResponseCodeEnum::ACCESS_DENIED         => 'Access Denied',
            ResponseCodeEnum::NOT_FOUND             => 'Page not found',
            ResponseCodeEnum::REQUEST_URI_TOO_LONG  => 'Request URI too long',
            ResponseCodeEnum::SERVICE_UNAVAILABLE   => 'Service Unavailable',
            ResponseCodeEnum::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        };
    }

    public function label() : string
    {
        return ResponseCodeEnum::getLabel($this);
    }
}