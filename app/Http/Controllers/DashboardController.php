<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        $boards = DB::table('boards')->paginate(10);
        $users = DB::table('users');
        return view(
            'dashboard.index',
            [
                'boards' => $boards,
                'users' => $users
            ]
        );
    }
}
