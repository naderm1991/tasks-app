<?php
/* tests\utilities\functions.php */
function create($class, $attributes = [], $times = null)
{
    return \App\Models\Task::factory($class, $times)->create($attributes);
}
function make($class, $attributes = [], $times = null)
{
    return \App\Models\Task::factory($class, $times)->make($attributes);
}
function raw($class, $attributes = [], $times = null)
{
    return \App\Models\Task::factory($class, $times)->raw($attributes);
}
