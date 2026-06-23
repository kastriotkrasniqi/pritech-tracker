<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_tag(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('tags.store'), ['name' => 'bug', 'color' => '#ef4444'])
            ->assertRedirect(route('tags.index'));

        $this->assertDatabaseHas('tags', ['name' => 'bug', 'color' => '#ef4444']);
    }

    public function test_tag_name_must_be_unique(): void
    {
        $user = User::factory()->create();
        Tag::factory()->create(['name' => 'duplicate']);

        $this->actingAs($user)
            ->post(route('tags.store'), ['name' => 'duplicate'])
            ->assertSessionHasErrors('name');
    }

    public function test_can_attach_a_tag_to_an_issue_via_ajax(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('issues.tags.attach', [$issue, $tag]));

        $response->assertOk()->assertJsonStructure(['tags']);
        $this->assertDatabaseHas('issue_tag', ['issue_id' => $issue->id, 'tag_id' => $tag->id]);
    }

    public function test_can_detach_a_tag_from_an_issue_via_ajax(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $tag = Tag::factory()->create();
        $issue->tags()->attach($tag->id);

        $response = $this->actingAs($user)
            ->deleteJson(route('issues.tags.detach', [$issue, $tag]));

        $response->assertOk();
        $this->assertDatabaseMissing('issue_tag', ['issue_id' => $issue->id, 'tag_id' => $tag->id]);
    }
}
