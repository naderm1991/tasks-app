<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{

    private int $company_id = 0;
    public function setUp(): void
    {
        parent::setUp();
        $this->setBaseRoute('tasks');
        $this->setBaseModel('App\Models\Task');
        $this->company_id = Company::factory()->create()->id;
    }

    /** @test */
    public function add_new_task(){
        User::factory()->create([
            'is_admin' => 1,
            'company_id'=>$this->company_id
        ]);
        User::factory()->create([
            'is_admin' => 0,
            'company_id'=>$this->company_id
        ]);
        $this->create();
    }

    /** @test  */
    public function testTasksRoute()
    {
        $this->withoutMiddleware();
        $task = Task::factory()->create();
        $response = $this->get('/tasks');
        $this->assertStringContainsString($task->title, $response->content());
        $this->assertStringContainsString($task->description, $response->content());
        $response->assertSuccessful();
    }

    /**
     * @test
     * @return void
     */
    public function testUserStatisticsRoutes(): void
    {
        $this->AddDummyData();
        $response = $this->get('/statistics/user_tasks_count');
        $response->assertSuccessful();
    }

    private function AddDummyData()
    {
        $admin =  User::factory()->create([
            'is_admin' => 1,
            'company_id' => $this->company_id
        ]);
        $user = User::factory()->create([
            'is_admin' => 0,
            'company_id' => $this->company_id
        ]);

        Task::factory(1)->create([
            'assigned_by_id' =>$admin->id,
            'assigned_to_id' =>$user->id,
        ]);
    }


}
