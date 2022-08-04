<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $base_route = null;
    protected $base_model = null;

    /**
     * @param null $base_route
     */
    public function setBaseRoute($base_route): void
    {
        $this->base_route = $base_route;
    }

    /**
     * @param null $base_model
     */
    public function setBaseModel($base_model): void
    {
        $this->base_model = $base_model;
    }

    protected function create($attributes=[], $model='',$route=''): TestResponse
    {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.store":$route;
        $model = $this->base_model ?? $model;

        $attributes = raw($model, $attributes);

        $response = $this->postJson(
            route($route),
            (array)$attributes
        )->assertRedirect('tasks');

        $model = new $model;

        $this->assertDatabaseHas($model->getTable(),$attributes);

        return $response;
    }

}
