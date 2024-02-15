<?php

namespace App\Shared\Infrastructure\Security;

use Auth0\SDK\API\Management;
use Auth0\SDK\Auth0;

interface Auth0Interface
{
    public function getAuth(): Auth0;

    public function getManagement(): Management;
}
