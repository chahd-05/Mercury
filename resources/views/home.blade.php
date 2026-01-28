<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <a href="/contact">Add contact</a>

    @if(isset($edit_group))
        <h3>Edit group</h3>
        <form action="/groups/{{ $edit_group->id }}/update" method="post">
            @csrf
            <input type="text" name="group_name" value="{{ $edit_group->group_name }}" placeholder="enter your group_name">
            <input type="text" name="description" value="{{ $edit_group->description }}" placeholder="description...">
            <button type="submit">Update</button>
        </form>
        <a href="/">Cancel</a>
    @else
        <h3>Create group</h3>
        <form action="/create_group" method="post">
            @csrf
            <input type="text" name="group_name" placeholder="enter your group_name">
            <input type="text" name="description" placeholder="description...">
            <button type="submit">Create</button>
        </form>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <h3>Groups</h3>
    @foreach($groups as $group)
        <div style="border:1px solid #ddd;padding:8px;margin:6px;">
            <h2>{{ $group->group_name }}</h2>
            <p>{{ $group->description }}</p>
            <a href="/groups/{{ $group->id }}/edit">Edit</a>
            <form action="/groups/{{ $group->id }}/delete" method="post" style="display:inline" onsubmit="return confirm('Delete group?');">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach

</body>
</html>
