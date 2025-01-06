<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryUserController extends Controller
{
    public function  historyUser()
    {
        $histories = History::get();
      
        return view('admin.history_user.index', compact('histories'));
    }
    public function  showUser(string $id)
    {
        $data = History::findOrFail($id);
        dd( $data ->changes);
        $dataold = $data->model_id;
        $admin = Admin::findOrFail($dataold);
        return view('admin.history.show', compact('data', 'admin'));
    }
    
    
}
