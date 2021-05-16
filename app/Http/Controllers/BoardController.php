<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::with(['user', 'boardUsers']);

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

        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards
            ]
        );
    }

    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();
        $tasks = DB::table('tasks')->paginate(10);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board = clone $boards;
        $board = $board->where('id', $id)->first();

        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }

        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards,
                'tasks' => $tasks,
            ]
        );
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function updateBoard(Request $request): RedirectResponse
    {
        $error = '';
        $success = '';

        if ($request->has('id')) {
            /** @var Board $board */
            $board = Board::find($request->get('id'));

            $board->name = $request->name;
            $board->save();

        return redirect()->back()->with([
            'error' => $error, 'success' => $success
        ]);
    }
}

    /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function updateBoardAjax(Request $request, $id): JsonResponse
    {
        $board = Board::find($id);

        $error = '';
        $success = '';
        $board->name = $request->name;
        $board->save();
        

        return response()->json(['error' => $error, 'success' => $success, 'board' => $board]);
    }

    public function deleteBoard($id)
    { 
        $board = Board::find($id);
        $board->delete();

        return response()->json('Board deleted', 200);
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */

}
