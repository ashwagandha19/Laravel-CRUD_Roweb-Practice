<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $user = Auth::user();

        $boards= Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }
        
        
        $users =  User::all();
        $boardsAll = Board::all();
        $tasks = Task::all();
        return view('dashboard.index', ['users' => $users, 'boards' => $boards, 'tasks' => $tasks, 'boards' => $boards, 'user' => $user, 'boardsAll' => $boardsAll]);
    }
}
