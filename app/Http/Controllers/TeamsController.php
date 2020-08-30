<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class TeamsController extends Controller
{
    //

    public function addteams()
    {
        $name = request('name');
        $count = DB::table('teams')->where('teamname',$name)->count();

        if ($count == 0)
        {
            $id = DB::table('teams')->insertGetId(
                ['teamname' => $name]
            );
            return response()->json([
                'id' => $id ,
                'name' => $name,
            ]);
        }
        return response()->json([
            'message' => 'this team already exist'
        ]);
        // dd("This team already exists");
    }


    public function showteam($id)
    {
        $teams = DB::table('teams')->where('id' , $id )->get();
        //return  Response::json($teams, 200);
        if (count($teams) == 0 )
        {
            return response()->json([
                'message' => "No team found with this id"
            ]);
        }
        return response()->json([
            'id' => $teams[0]->id ,
            'name' => $teams[0]->teamname,
        ]);
    }

    public function addmember($id)
    {
        $membername = request('name');
        $email = request('email');
        $count = DB::table('teams')
                    ->where('id' , $id)
                    ->count();
        if ($count == 0)
        {
            return response()->json([
                'message' => "team doesn't exists'"
            ]);
            //dd("team doesn't exists");
        }

        
        $count = DB::table('tasks')
                    ->join('members', 'tasks.memberid', '=', 'members.id')
                    ->where('teamid' , $id)
                    ->where('members.email' , $email)
                    ->count();

        if ($count == 0)
        {
            $memberid = DB::table('members')
                    ->select('id')
                    ->where('membername' , $membername)
                    ->where('email' , $email)
                    ->first();
            if ($memberid == null )
            {
                $memberid = DB::table('members')->insertGetId(
                    ['membername' => $membername , 'email' => $email]
                );

            } else {
                $memberid = $memberid->id ;
            }
            $taskid = DB::table('tasks')->insertGetId(
                ['teamid' => $id , 'memberid' => $memberid , 'task' => '' , 'status'=>'' ]
            );
            return response()->json([
                'message' => "member successfully added",
                'team id' => $id,
                'member name' => $membername,
                'email' => $email
            ]);

            
        }
        return response()->json([
            'message' => "This email is already registered with the team"
        ]);
        // dd("This email is already registered with the team");
    }

    public function posttask($id)
    {
        $memberid = request('assigned_to');
        $task = request('title') ;
        $status = request('status');
        if ($status != 'todo' && $status!='done'){
            return response()->json([
                'message' => "unexpected status, status can be todo or done only"
            ]);
            // dd('unexpected status, status can be todo or done only');
        }

        $count = DB::table('tasks')
                ->where('teamid' , $id)
                ->where('memberid' , $memberid)
                ->count();
        if ($count == 0 )
        {
            return response()->json([
                'message' => "member doesn't belong to this team"
            ]);
            //dd("member doesn't belong to this team");
        }

        $taskid = DB::table('tasks')->insertGetId(
            ['teamid' => $id , 'memberid' => $memberid , 'task' => $task , 'status'=>$status ]
        );
        return response()->json([
            'task id' => $taskid ,
            'Assigned to' => $memberid,
            'task title' => $task,
            'status' => $status
        ]);



    }

    public function gettask($id , $id2)
    {
        $tasks = DB::table('tasks')
        ->select('task')
        ->where('teamid' , $id)
        ->where('id' , $id2)
        ->get();
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i] = $tasks[$i]->task;
        }

        return response()->json([
            'team id' => $id ,
            'task id ' => $id2,
            'All available tasks' => $tasks
        ]);

    }

    public function teamtasks($id)
    {
        $tasks = DB::table('tasks')
        ->select('id','task' , 'status')
        ->where('teamid' , $id)
        ->get();
        
        return response()->json([
            'team id' => $id ,
            'All available tasks' => $tasks
        ]);

    }
    public function teamtaskstodo($id)
    {
        $tasks = DB::table('tasks')
        ->select('id','task' , 'status')
        ->where('teamid' , $id)
        ->where('status' , 'todo')
        ->get();
        
        return response()->json([
            'team id' => $id ,
            'All available tasks' => $tasks
        ]);

    }

    public function teammembertaskstodo($id , $id2)
    {
        $tasks = DB::table('tasks')
        ->select('task')
        ->where('teamid' , $id)
        ->where('memberid' , $id2)
        ->where('status' , 'todo')
        ->get();
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i] = $tasks[$i]->task;
        }

        return response()->json([
            'team id' => $id ,
            'member id ' => $id2,
            'All available tasks' => $tasks
        ]);

    }

    public function statusupdate($teamid , $taskid)
    {
        $status = request('status');
        if ($status!='todo' && $status!='done')
        {
            return response()->json([
                'message' => "incorrect status. Status can only be todo or done"
            ]);
            //dd('incorrect status. Status can only be todo or done');
        }
        $affected = DB::table('tasks')
              ->where('id' , $taskid)
              ->where('teamid', $teamid)
              ->update(['status' => $status]);
        $msg = $affected .' tasks affected';
        return response()->json([
                'message' => $msg,
                'task id' => $taskid ,
                'status set to' => $status
            ]);
    }
    public function deletemember($teamid , $memberid)
    {
        $count = DB::table('tasks')
            ->where('memberid' , $memberid)
            ->where('teamid', $teamid)
            ->where('status' , 'todo')
            ->count();

        if ($count >0)
        {
            return response()->json([
                'message' => 'Member cannot be deleted as there are tasks to do'
            ]);
        }
        DB::table('tasks')
            ->where('memberid' , $memberid)
            ->where('teamid', $teamid)
            ->where('task' , '')
            ->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }


    
}


