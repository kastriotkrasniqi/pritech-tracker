<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => 'Test Project',
            'description' => 'A description',
            'start_date' => '2026-01-01',
            'deadline' => '2026-06-01',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('projects', ['name' => 'Test Project', 'created_by' => $user->id]);
    }

    public function test_project_owner_can_delete_their_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);

        $this->actingAs($user)
            ->delete(route('projects.destroy', $project))
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_non_owner_cannot_delete_a_project(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('projects.destroy', $project))
            ->assertForbidden();
    }
}
