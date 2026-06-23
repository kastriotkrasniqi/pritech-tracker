<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_an_issue(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->post(route('projects.issues.store', $project), [
            'title' => 'Test Issue',
            'description' => 'Some details',
            'status' => 'open',
            'priority' => 'high',
            'due_date' => '2026-12-01',
        ]);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('issues', ['title' => 'Test Issue', 'project_id' => $project->id]);
    }

    public function test_issue_list_filters_by_status(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        Issue::factory()->create(['project_id' => $project->id, 'status' => 'open', 'title' => 'Open Issue']);
        Issue::factory()->create(['project_id' => $project->id, 'status' => 'closed', 'title' => 'Closed Issue']);

        $response = $this->actingAs($user)->get(route('projects.show', $project) . '?status=open');

        $response->assertSee('Open Issue')->assertDontSee('Closed Issue');
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $project = Project::factory()->create();

        $this->get(route('projects.show', $project))->assertRedirect(route('login'));
    }
}
