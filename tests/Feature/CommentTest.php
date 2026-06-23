<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_load_comments_paginated_via_ajax(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        Comment::factory(15)->create(['issue_id' => $issue->id]);

        $response = $this->actingAs($user)
            ->getJson(route('issues.comments.index', $issue));

        $response->assertOk()
            ->assertJsonStructure(['data', 'next_page_url', 'current_page', 'last_page'])
            ->assertJsonCount(10, 'data');
    }

    public function test_can_add_a_comment_via_ajax(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        $issue = Issue::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($user)->postJson(route('issues.comments.store', $issue), [
            'author_name' => 'Jane Doe',
            'body' => 'This is a comment.',
        ]);

        $response->assertStatus(201)->assertJsonStructure(['id', 'author_name', 'body', 'created_at']);
        $this->assertDatabaseHas('comments', ['issue_id' => $issue->id, 'author_name' => 'Jane Doe']);
    }

    public function test_comment_validation_rejects_empty_body(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['created_by' => $user->id]);
        $issue = Issue::factory()->create(['project_id' => $project->id]);

        $this->actingAs($user)->postJson(route('issues.comments.store', $issue), [
            'author_name' => 'Jane',
            'body' => '',
        ])->assertStatus(422)->assertJsonValidationErrors('body');
    }
}
