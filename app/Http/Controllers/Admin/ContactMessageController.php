<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $contacts = ContactMessage::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
        })->paginate(10); 
    
        return view('admin.contact.index', compact('contacts', 'search'));
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
