<?php

namespace App\Builders;

use App\Models\Login;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Parent_;

class UserBuilder extends Builder
{
    public static function query(): \Illuminate\Database\Query\Builder
    {
        return UserBuilder::query();
    }

    public function withLastLogin(): static
    {
        $this
            ->addSelect( ['last_login_id' => Login::query()->select('id')
                ->whereColumn('user_id','users.id')->latest()->take(1)])
            ->with('lastLogin')
        ;

        return $this;
    }
}
