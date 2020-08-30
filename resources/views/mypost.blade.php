<!DOCTYPE html>
<html>
<head>

<title>
</title>

</head>
<body>
    <h1>Hi Post</h1>

    <ul>
        <?= 
        $name;
        //$teams = DB::table('teams')->get();
        $teams = DB::table('tasks')->join('teams', 'tasks.teamid', '=', 'teams.id')->join('members', 'tasks.memberid', '=', 'members.id')->get();?>
        jhgjhgj
        @foreach ($teams as $task) 
            <li> {{$task->task}} </li>
        @endforeach
    </ul>

</body>
</html>
