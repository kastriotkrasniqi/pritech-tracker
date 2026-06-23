<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function index(Issue $issue): JsonResponse
    {
        $comments = $issue->comments()
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $comments->map(fn ($c) => [
                'id'          => $c->id,
                'author_name' => $c->author_name,
                'body'        => $c->body,
                'created_at'  => $c->created_at->diffForHumans(),
            ]),
            'next_page_url' => $comments->nextPageUrl(),
            'current_page'  => $comments->currentPage(),
            'last_page'     => $comments->lastPage(),
        ]);
    }

    public function store(StoreCommentRequest $request, Issue $issue): JsonResponse
    {
        $comment = $issue->comments()->create($request->validated());

        return response()->json([
            'id'          => $comment->id,
            'author_name' => $comment->author_name,
            'body'        => $comment->body,
            'created_at'  => $comment->created_at->diffForHumans(),
        ], 201);
    }
}
