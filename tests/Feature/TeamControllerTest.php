<?php

namespace Tests\Feature;

use App\Http\Controllers\TeamController;
use PHPUnit\Framework\TestCase;

class TeamControllerTest extends TestCase
{
    public function test_start_method()
    {
        $teamController = TeamController::start('team name', ['member 1', 'member 2']);

        $this->assertEquals('team name', $teamController->name());
        $this->assertEquals(['member 1', 'member 2'], $teamController->members());
    }
}
