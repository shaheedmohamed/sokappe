<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    public function update(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}
