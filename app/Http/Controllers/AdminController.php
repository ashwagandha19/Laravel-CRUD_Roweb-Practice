<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    //* show users function
    public function users()
    {
        $users = DB::table('users')->paginate(10);

        return view(
            'users.index',
            [
                'users' => $users
            ]
        );
    }
    //* end show users function


    //* update users function
    public function edit($id) {
        $user = User::find($id);

        if($user) {
            return response()->json($user, 200);
        }
        else {
            return response()->json('User not found');
        }
    } 
    //* end update users function

        //* update users function
        public function update(Request $request, $id) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->save();

            return response()->json($user, 200);
        } 


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('User deleted', 200);
    }


}