<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function create(Request $request){
        $req = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        
        $data = $req;
        if ($request->filled('group_id')) {
            $data['group_id'] = $request->input('group_id');
        }
        Contact::create($data);
        return redirect('/contact')->with('success', 'Contact created successfully');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return redirect('/contact')->with(['edit_contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        $req = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $contact = Contact::findOrFail($id);
        $contact->update(array_merge($req, ['group_id' => $request->input('group_id')]));
        return redirect('/contact')->with('success', 'Contact updated successfully');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect('/contact')->with('success', 'Contact deleted successfully');
    }
}
