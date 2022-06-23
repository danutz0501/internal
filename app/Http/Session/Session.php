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
 *  Session.php   June / 2022
 */
declare(strict_types=1);
namespace GamerHelpDesk\Http\Session;

use GamerHelpDesk\Http\Helper\SingletonTrait;

class Session implements \SessionHandlerInterface, \SessionUpdateTimestampHandlerInterface
{
    use SingletonTrait;

    private function __construct()
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public function close(): bool
    {
        // TODO: Implement close() method.
    }

    public function destroy(string $id): bool
    {
        // TODO: Implement destroy() method.
    }

    public function gc(int $max_lifetime): int|false
    {
        // TODO: Implement gc() method.
    }

    public function open(string $path, string $name): bool
    {
        // TODO: Implement open() method.
    }

    public function read(string $id): string|false
    {
        // TODO: Implement read() method.
    }

    public function write(string $id, string $data): bool
    {
        // TODO: Implement write() method.
    }

    public function validateId(string $id): bool
    {
        // TODO: Implement validateId() method.
    }

    public function updateTimestamp(string $id, string $data): bool
    {
        // TODO: Implement updateTimestamp() method.
    }
}