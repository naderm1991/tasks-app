<?php

namespace Tests\Unit;

use Tests\TestCase;
class TasksTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTasksRouteResponseStatus()
    {
        $response = $this->get('tasks');

        $response->assertStatus(200);

    }
}
