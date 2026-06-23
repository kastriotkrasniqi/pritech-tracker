<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 3 users (including a known demo account)
        $users = User::factory(2)->create();
        $demo = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);
        $users->push($demo);

        // 10 tags
        $tags = Tag::factory(10)->create();

        // 5 projects: 3 owned by demo user, 2 by another user
        $projects = collect();
        $projects = $projects->merge(Project::factory(3)->create(['created_by' => $demo->id]));
        $projects = $projects->merge(Project::factory(2)->create(['created_by' => $users->first()->id]));

        // 4-6 issues per project
        $projects->each(function (Project $project) use ($tags, $users) {
            $issues = Issue::factory(rand(4, 6))->create(['project_id' => $project->id]);

            $issues->each(function (Issue $issue) use ($tags, $users) {
                // Attach 1-3 random tags
                $issue->tags()->attach($tags->random(rand(1, 3))->pluck('id'));

                // Assign 1-2 random users
                $issue->assignees()->attach($users->random(rand(1, 2))->pluck('id'));

                // 3-15 comments per issue
                Comment::factory(rand(3, 15))->create(['issue_id' => $issue->id]);
            });
        });
    }
}
