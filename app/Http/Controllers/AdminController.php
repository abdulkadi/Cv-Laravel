<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Information;
use App\Models\Resume;
use App\Models\Skils;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login (){
        return view('adminPanel.login');
    }
    public function dashboard (){
        $contacts = Contact::orderBy('id', 'desc')->paginate(10);
        $information = Information::first();
        
        return view('adminPanel.index', compact('contacts','information'));

    }
    public function information ()
    {
        $information = Information::first();
        return view('adminPanel.information', compact('information'));
    }
    public function getContactDetails($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['error' => 'Contact not found'], 404);
        }

        return response()->json([
            'name' => $contact->name,
            'message' => $contact->message
        ]);
    }

    public function skils(){
        $information = Information::first();
        $skil=Skils::all();
        $resume= Resume::all();

        return view('adminPanel.skils',compact('information','skil','resume'));
    }
    public function edit(){
        $information = Information::first();
        $skil=Skils::all();
        $resume= Resume::all();

        return view('auth.edit',compact('information','skil','resume'));
    }
}
