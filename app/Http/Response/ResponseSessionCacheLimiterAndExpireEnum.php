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
 *  ResponseSessionCacheLimiterAndExpireEnum.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Response;

/**
 *VALUES ACCORDING TO PHP.net
 *public
 *Expires: (sometime in the future, according session.cache_expire)
 *Cache-Control: public, max-age=(sometime in the future, according to session.cache_expire)
 *Last-Modified: (the timestamp of when the session was last saved)
 *
 *private_no_expire
 *
 *Cache-Control: private, max-age=(session.cache_expire in the future), pre-check=(session.cache_expire in the future)
 *Last-Modified: (the timestamp of when the session was last saved)
 *
 *private
 *
 *Expires: Thu, 19 Nov 1981 08:52:00 GMT
 *Cache-Control: private, max-age=(session.cache_expire in the future), pre-check=(session.cache_expire in the future)
 *Last-Modified: (the timestamp of when the session was last saved)
 *
 *nocache
 *
 *Expires: Thu, 19 Nov 1981 08:52:00 GMT
 *Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
 *Pragma: no-cache
 *
 * Useful if you don't want to set these headers manually
 */

enum ResponseSessionCacheLimiterAndExpireEnum : string
{
    case PUBLIC            = 'public';
    case PRIVATE_NO_EXPIRE = 'private_no_expire';
    case PRIVATE           = 'private';
    case NOCACHE           = 'nocache';

    /**
     * @param int|null $value
     * @return int|false
     * wrapper for session_cache_expire, which is used for max age cache in browser, not for sessions
     * BUT YOU MUST CALL IT BEFORE session_start()
     * @url https://www.php.net/manual/en/function.session-cache-expire.php
     */
    public static function session_cache_expire(?int $value = null) : int|false
    {
        return session_cache_expire($value);
    }

    /**
     * @param string|null $value
     * @return string|false
     * wrapper for session_cache_limiter, which is used to control which cache control HTTP are sent to the client, not for session
     * BUT YOU MUST CALL IT BEFORE session_start(), use enum cases
     * @url https://www.php.net/manual/en/function.session-cache-limiter.php
     */
    public static function session_cache_limiter(?string $value = null) : string|false
    {
        return session_cache_limiter($value);
    }

}