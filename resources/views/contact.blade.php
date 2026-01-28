<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <a href="/">Back to home</a>
    <form action="/contact" method="get" style="margin-bottom:12px;">
        @csrf
        <select name="group">
            <option value="">-- All groups --</option>
            @foreach($groups as $g)
                <option value="{{ $g->id }}" {{ request('group') == $g->id ? 'selected' : '' }}>{{ $g->group_name }}</option>
            @endforeach
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name">
        <button type="submit">Filter / Search</button>
    </form>

    @php
        $isEdit = isset($edit_contact) && $edit_contact;
    @endphp

    <form action="{{ $isEdit ? '/contact/' . $edit_contact->id . '/update' : '/contact' }}" method="post">
        @csrf
        @if($isEdit)
            <input type="hidden" name="_method" value="POST">
        @endif
        <input type="text" name="name" placeholder="enter your name" value="{{ $isEdit ? $edit_contact->name : '' }}">
        <input type="email" name="email" placeholder="enter your email" value="{{ $isEdit ? $edit_contact->email : '' }}">
        <input type="text" name="phone" placeholder="enter your number" value="{{ $isEdit ? $edit_contact->phone : '' }}">
        <select name="group_id">
            <option value="">-- No group --</option>
            @foreach($groups as $g)
                <option value="{{ $g->id }}" {{ ($isEdit && $edit_contact->group_id == $g->id) || request('group') == $g->id ? 'selected' : '' }}>{{ $g->group_name }}</option>
            @endforeach
        </select>
        <button type="submit">{{ $isEdit ? 'Update' : 'Create' }}</button>
        @if($isEdit)
            <a href="/contact">Cancel</a>
        @endif
    </form>
    @if(session('success'))
     <p style="color: green;">{{session('success')}}</p>
     @endif
     @if($errors->any())
    <p style="color:red">{{ $errors->first() }} </p>
    @endif
     @foreach($contacts as $contact)
        <div style="border:1px solid #ccc;padding:8px;margin:6px;">
            <h4>{{ $contact->name }}</h4>
            <p>{{ $contact->email }}</p>
            <p>{{ $contact->phone }}</p>
            <p>Group: {{ $contact->group ? $contact->group->group_name : '—' }}</p>
            <a href="/contact/{{ $contact->id }}/edit">Edit</a>
            <form action="/contact/{{ $contact->id }}/delete" method="post" style="display:inline" onsubmit="return confirm('Delete contact?');">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach
</body>
</html>