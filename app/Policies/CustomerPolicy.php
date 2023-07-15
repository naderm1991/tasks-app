<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user,Customer $customer): bool
    {
        // if the user is the owner of the company or the sales rep of the customer
        return $user->is_owner || $user->id === $customer->sales_rep_id;
    }
}
