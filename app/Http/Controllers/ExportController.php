<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function index()
    {
        $users = User::all();
        // return response()->xml(['user' => $user->toArray()]);
        $data['users'] = [];
        foreach($users as $user) {
            $data['users'][] = [
                'Name' => $user->name,
                'email' => $user->email,
            ];
        }
        return response()->xml(['users' => $data])->header('Content-Disposition', 'attachment; filename="filename.xml"');
    }
}
