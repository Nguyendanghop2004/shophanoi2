<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\HistorieAdmins;

class HistoryController extends Controller
{
    public function  history()
    {
        $histories = HistorieAdmins::get();

        return view('admin.history.index', compact('histories'));
    }
    public function  show(string $id)
    {

        $data = HistorieAdmins::findOrFail($id);
        $dataold = $data->model_id;
        $admin = Admin::findOrFail($dataold);
        return view('admin.history.show', compact('data', 'admin'));
    }
    public function  delete(string $id)
    {

        $dataUser = HistorieAdmins::findOrFail($id);
        $dataUser->delete();
        return back()->with('success', 'Xóa thành công');
    }
}
