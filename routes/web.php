<?php


use App\Models\Contact;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;
use App\Models\Group;
use Illuminate\Http\Request;

Route::get('/contact', function (Request $request) {
    $query = Contact::query();
    if ($request->filled('group')) {
        $query->where('group_id', $request->input('group'));
    }
    if ($request->filled('search')) {
        $s = $request->input('search');
        $query->where('name', 'like', "%{$s}%");
    }
    $contacts = $query->get();
    $groups = Group::all();
    $edit_contact = session('edit_contact');
    return view('contact', ["contacts" => $contacts, 'groups' => $groups, 'edit_contact' => $edit_contact]);
});


Route::post('/contact', [ContactsController::class , "create"]);
Route::post('/contact/{id}/update', [ContactsController::class, 'update']);
Route::delete('/contact/{id}/delete', [ContactsController::class, 'destroy']);
Route::get('/contact/{id}/edit', [ContactsController::class, 'edit']);

Route::get('/', function(){
    $groups = Group::all();
    return view('home', ["groups" => $groups]);
});


Route::post('/create_group', function (Request $request) {
    $data = $request->validate([
        'group_name' => 'required|unique:groups,group_name',
        'description' => 'nullable'
    ]);
    Group::create($data);
    return redirect('/')->with('success', 'Group created successfully');
});

Route::get('/groups/{id}/edit', function ($id) {
    $group = Group::findOrFail($id);
    $groups = Group::all();
    return view('home', ['groups' => $groups, 'edit_group' => $group]);
});

Route::post('/groups/{id}/update', function (Request $request, $id) {
    $data = $request->validate([
        'group_name' => 'required|unique:groups,group_name,'.$id,
        'description' => 'nullable'
    ]);
    $group = Group::findOrFail($id);
    $group->update($data);
    return redirect('/')->with('success', 'Group updated successfully');
});

Route::delete('/groups/{id}/delete', function ($id) {
    $group = Group::findOrFail($id);
    $group->contacts()->update(['group_id' => null]);
    $group->delete();
    return redirect('/')->with('success', 'Group deleted successfully');
});


