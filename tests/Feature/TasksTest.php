<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->setBaseRoute('tasks');
        $this->setBaseModel('App\Models\Task');
    }

    /** @test */
    public function add_new_task(){
        $admin =  User::factory()->create([
            'is_admin' => 1
        ]);
        $user = User::factory()->create([
            'is_admin' => 0
        ]);
        $this->create();
    }

    /** @test  */
    public function testTasksRoute()
    {
        $this->withoutMiddleware();
        Task::factory(1)->create();
        $response = $this->get('/tasks');
        $this->assertStringContainsString('task', $response->content());
        $response->assertSuccessful();
    }

    /**
     * @test
     * @return void
     */
    public function testUserStatisticsRoutes()
    {
        $this->AddDummyData();
        $response = $this->get('/statistics/tasks');
        $response->assertSuccessful();
    }

    private function AddDummyData()
    {
        $admin =  User::factory()->create([
            'is_admin' => 1
        ]);
        $user = User::factory()->create([
            'is_admin' => 0
        ]);
        $tasks = Task::factory(1)->create([
            'assigned_by_id' =>$admin->id, // password
            'assigned_to_id' =>$user->id, // password
        ]);
    }


}
