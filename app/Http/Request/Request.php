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
 *  Request.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Request;

class Request
{
    const HTTP_VERBS = 'GET|POST';
    protected readonly string $rawUri;

    public function __construct()
    {
        $this->rawUri = $_SERVER['REQUEST_URI'];
    }

    public function isAjax() : bool
    {
        return isset($_SERVER['HTTP_X_REQUEST_WITH']) && strtolower($_SERVER['HTTP_X_REQUEST_WITH']) === "xmlhttprequest";
    }

    public function getRawUri() : string
    {
        return $this->rawUri;
    }

    public function getCleanUri() : string
    {
        return preg_replace('/[^\da-z\-\/]/i', '', filter_var($this->getRawUri(), FILTER_SANITIZE_URL));
    }

    public function getRequestMethod() : string
    {
        return $method = isset($_SERVER['REQUEST_METHOD']) && !empty($_SERVER['REQUEST_METHOD']) && preg_match('/'.self::HTTP_VERBS.'/', strtoupper($_SERVER['REQUEST_METHOD'])) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
    }


}