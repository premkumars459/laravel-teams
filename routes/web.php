<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $name = 'Welcome User';
    return view('welcome',compact('name'));
});

Route::get('/token/', function () {
    return csrf_token();
});

Route::post('/teams', 'TeamsController@addteams'); //....... add teams  request : teamname 

Route::get('/teams/{id}/tasks/todo','TeamsController@teamtaskstodo'); //....... fetch tasks to do by team id 

Route::get('/teams/{id}','TeamsController@showteam'); //....... show team with id 

Route::post('/teams/{id}/member','TeamsController@addmember'); //....... add a member to team with id request: membername, email 

Route::post('/teams/{id}/tasks','TeamsController@posttask'); //......add task to a team member in team with id; request title, assigned to, status 

Route::get('/teams/{id}/tasks/{id2}' , 'TeamsController@gettask'); //....... show task for a given team id and task id 

Route::patch('/teams/{id}/tasks/{id2}', 'TeamsController@statusupdate'); //.... change status of a task; request: title,status

Route::get('/teams/{id}/tasks/','TeamsController@teamtasks'); //........shows all tasks of a team.

Route::get('/teams/{id}/taskstodo','TeamsController@teamtaskstodo'); //........ shows all tasks to do of a team.

Route::get('/teams/{id}/member/{id2}/tasks/' , 'TeamsController@teammembertaskstodo'); //....... shows all tasks to do by a team member.

Route::delete('/teams/{id}/member/{id2}' , 'TeamsController@deletemember') ; //..... delete a team member if there are no tasks to do by the member.