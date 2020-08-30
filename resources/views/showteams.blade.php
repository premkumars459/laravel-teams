<!DOCTYPE html>
<html>
<head>

<title>
</title>

</head>
<body>
    <h1>Teams:</h1>

    <ul>
        <?php foreach ($teams as $team){
            echo "requested team id : $team->id <br>";
            echo "team name : $team->teamname <br>";
        }
        ?>
    </ul>

</body>
</html>
