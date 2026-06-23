<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class IssueTagController extends Controller
{
    public function attach(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->syncWithoutDetaching([$tag->id]);
        $issue->load('tags');

        return response()->json([
            'tags' => $issue->tags->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'color' => $t->color ?? '#6b7280',
            ]),
        ]);
    }

    public function detach(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->detach($tag->id);
        $issue->load('tags');

        return response()->json([
            'tags' => $issue->tags->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'color' => $t->color ?? '#6b7280',
            ]),
        ]);
    }
}
