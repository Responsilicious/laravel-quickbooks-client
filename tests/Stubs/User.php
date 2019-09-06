<?php

namespace Responsilicious\QuickBooks\Stubs;

use Responsilicious\QuickBooks\HasQuickBooksToken;

/**
 * Class User
 *
 * Stub for a Laravel User model
 *
 * @package Responsilicious\QuickBooks\Stubs
 */
class User
{
    use HasQuickBooksToken;

    public function hasOne($relationship)
    {
        return $relationship;
    }
}
