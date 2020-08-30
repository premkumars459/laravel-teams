The following routes have been set-up:

get         /                                    welcome page. you can find csrf token here

get        /token                                get find csrf token 

post       /teams                                add teams  request : teamname                                          request: team name with key as name

get        /teams/{id}/tasks/todo                fetch tasks to do by team id 

get        /teams/{id}'                          show team with id 

post       /teams/{id}/member                    add a member to team with id                                           request: membername, email with key                                                                                                                                 key: membername and email 

post      /teams/{id}/tasks                      add task to a team member in team with id;                             request: title , assigned to 
                                                                                                                        key : title, assigned_to 
                                                                                                                        
get       /teams/{id}/tasks/{id2}                show task for a given team id and task id 

patch     /teams/{id}/tasks/{id2}                change status of a task;                                               request: title,status
                                                                                                                        key: title, status

get       /teams/{id}/tasks/                     shows all tasks of a team.

get       /teams/{id}/taskstodo                  shows all tasks to do of a team.

get       /teams/{id}/member/{id2}/tasks/        shows all tasks to do by a team member.

delete    /teams/{id}/member/{id2}               delete a team member if there are no tasks to do by the member.


When using post, patch or delete method remember to add csrf token in header of the request with key 'X-CSRF-TOKEN'.

follow the request and key notations when using the methods where request are the required parameters and key are the keys to be used for those parameters.

To run using local system uding local databse make sure you have php, laravel, and mysql  change the database connection details in .env file. Then run the following in your terminal: 
1. php artisan migrate (to migrate all the required tables, this is one time)
2. php artisan serve (laravel server will start and you can start using the aplication)

Running in docker: 
In your terminal cd local project directory and run :
1. docker-compose up -d. or docker-compose build && docker-compose up -d
2. docker-compose exec blog_app bash
3. php artisan migrate
2. and 3. to be followed when using this for the first time. 



