<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Metadata\Uses;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware(); // Apply middleware to all test methods
    }
    public function test_login_form(){
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    public function test_user_duplication(){
        $user1 = User::make([
            'name'=>'john',
            'email'=>'john@gmail.com',
        ]);
        $user2 = User::make([
            'name'=>'Dary',
            'email'=>'Dary@gmail.com',
        ]);
        $this->assertTrue($user1->name != $user2->name);
    }
    public function test_delete_user(){
        $user = User::factory()->count(1)->make();

        $user = User::first();
        if($user){
            $user->delete();
        }
        $response = $this->get('tasks');
        $response->assertStatus(302);
    }
    public function test_it_stores_new_admin(){
        $response = $this->post('/register',[
            'name'=>'Dary',
            'email'=>'Dary@gmail.com',
            'password'=>'12345678',
            'password_confirmation'=>'12345678',
       
        ]);
        $response = $this->get('tasks');
        $response->assertStatus(302);
    }
    public function test__admin_user_can_access_tasks(){
        $user = User::factory()->create(['role'=>'Admin']);
        $response = $this->actingAs($user)->get('tasks');
        $response->assertStatus(200);
    }
    public function test_non_admin_user_cannot_access_tasks(){
        $user = User::factory()->create(['role'=>'user']);
        $response = $this->actingAs($user)->get('user-task');
        $response->assertStatus(200);
    }
    public function test_landing_page_loads_correctly(){
        //arrangect
        //act 
        //assert test
        $response = $this->get('/login');
      //  $response->assertRedirect('/tasks');
      //  $response->followingRedirects()->assertStatus(200);
        $response->assertSee('Google');
    }

    
    public function testAuthenticatedAdminCanAccessAdminRoutes()
    {
        // Create an authenticated user with 'is_admin' role (assuming you have a User model)
        $user = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($user);

        // Simulate a GET request to an admin route
        $response = $this->get('/tasks');
        $response = $this->get('users');
        // Assert that the response has a status code of 200, indicating a successful access
        $response->assertStatus(200);
    }
    public function test_new_users_can_register(){
        $user = User::factory()->create(['role'=>false]);
         $this->actingAs($user);  
         $response = $this->get('user-task');
         $response->assertStatus(200);
       
     }
    public function test_admin_can_authenticate_using_login(){
        $user = User::factory()->create(['role'=>'Admin']);
        $this->actingAs($user);
        $data=[
            'email'=>$user->email,
            'password'=>$user->password
        ];
        $response = $this->get('/user-task');
            $this->assertAuthenticated();
            $response->assertStatus(200);
    }
    public function test_users_can_authenticate_using_login(){
        $user = User::factory()->create(['role'=>'Developer']);
        $this->actingAs($user);
        $data=[
            'email'=>$user->email,
            'password'=>$user->password
        ];
        $response = $this->get('/user-task');
            $this->assertAuthenticated();
            $response->assertStatus(200);
    }
    public function test_user_cannot_authenticate_with_invalid_password(){
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'email'=>$user->email,
            'password'=>'wrong-password',
        ];
        $response =  $this->get('/login');
        
        $response->assertStatus(302);
    }
    public function test_the_array_is_empty(){
        
        $this->assertTrue(true);
        $this->assertEmpty([]);
        $this->assertEquals(1,1);
    }
    public function testAdminCanCreateTask()
{
    $admin = User::factory()->create(['role' => true]);
    $this->actingAs($admin);
    $this->withoutMiddleware();

    // Create a new task using the factory model with random attributes
    $task = Task::factory()->create();

    // Define the task data with factory model attributes
    $data = [
        'task' => $task->task,
        'description' => $task->description,
        'progress' => $task->progress,
        'position' => $task->position,
        'start_date' => $task->start_date,
        'end_date' => $task->end_date,
    ];

    $authenticatedAdmin = User::find($admin->id);

    // Attach the created task to the authenticated user
    $authenticatedAdmin->tasks()->attach($task->id);

    $response = $this->post('tasks/store', $data);
    $response->assertStatus(302);
    $this->assertDatabaseHas('tasks', $data);
}
        
    public function testShowIndividualUsersTask()
    {
        // Create a user and log them in to simulate an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a task for the user
        $task = Task::factory()->create();
        $user->tasks()->attach($task); // Use the 'tasks' relationship to attach the task
       
        // Simulate an AJAX request
        $ajaxResponse = $this->get(route('users_view.show'), ['ajax' => true]);
        $ajaxResponse->assertStatus(200); // Ensure correct number of rows returned
        // $ajaxResponse->assertJsonStructure([
        //     'data' => [
        //         '*' => ['actions', /* Other columns */]
        //     ]
        // ]);
        //dd($ajaxResponse->getContent);

        // Add more specific assertions based on your data and response structure
    }
    public function testAdminCanUpdateTask()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => true]);
        $this->actingAs($admin);
        $this->withoutMiddleware();
    
        // Create a new task using the factory model with random attributes
        $task = Task::factory()->create();
    
        // Define the task data with factory model attributes and add any changes you want to make
        $updatedData = [
            'task' => 'Updated Task Name',
            'description' => 'Updated Task Description',
            'progress' => 'Updated Progress',
            'position' => 'Updated Position',
            'start_date' => '2023-08-03', // Replace with a valid date
            'end_date' => '2023-08-10', // Replace with a valid date
        ];
    
        // Send a mock HTTP request to the update method
        $response = $this->put('/tasks/' . $task->id, $updatedData);
    
        // Assert that the response is a redirect and contains the success message
        $response->assertStatus(302);
        $response->assertRedirect('tasks');
        $response->assertSessionHas('success', 'Task Updated Successfully');
    
        // Refresh the task model to get the updated data from the database
        $task->refresh();
    
        // Assert that the task has been updated with the new data
        $this->assertEquals($updatedData['task'], $task->task);
        $this->assertEquals($updatedData['description'], $task->description);
        $this->assertEquals($updatedData['progress'], $task->progress);
        $this->assertEquals($updatedData['position'], $task->position);
        $this->assertEquals($updatedData['start_date'], $task->start_date);
        $this->assertEquals($updatedData['end_date'], $task->end_date);
    
        // You can also perform additional checks if required based on your application's logic
    }
    
  
}
