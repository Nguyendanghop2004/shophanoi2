<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::all();
        return view('admin.contact.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required|min:1',
            'phone' => 'required|numeric'
        ]);

        ContactMessage::create($validatedData);

        return redirect()->back()->with('success', 'Liên hệ đã được gửi thành công.');
    }
}
