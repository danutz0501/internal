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

use GamerHelpDesk\Http\Router\RouteAttribute;
use GamerHelpDesk\Http\Router\Router;

class Stream
{

    #[RouteAttribute(verb: 'get', regexToCompile: '/stream/home', method: __METHOD__)]
    public function home()
    {
        echo 'merge din stream home';
    }

    #[RouteAttribute(verb: 'get', regexToCompile: '/stream/start', method: __METHOD__)]
    public function start() : void
    {
        echo "Start stream";
    }

    #[RouteAttribute(verb: 'get', regexToCompile: '/stream/end', method: __METHOD__)]
    public function end() : void
    {
        echo "End stream";
    }

    #[RouteAttribute(verb: 'get', regexToCompile: '/stream/add-image', method: __METHOD__)]
    public function addImage() : void
    {
        echo "add an image";
    }

    #[RouteAttribute(verb: 'get', regexToCompile: '/stream/add-video', method: __METHOD__)]
    public function addVideo() : void
    {
        echo "add a video";
    }

    public function postImage() : void
    {
        if(!Router::init()->getRequest()->isAjax())
            throw new \BadMethodCallException(message: 'Upload the image using ajax.');
        echo "uploading a image";
    }
}