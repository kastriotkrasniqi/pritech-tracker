<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IssueUserController extends Controller
{
    public function attach(Issue $issue, User $user): JsonResponse
    {
        $issue->assignees()->syncWithoutDetaching([$user->id]);
        $issue->load('assignees');

        return response()->json([
            'assignees' => $issue->assignees->map(fn ($u) => [
                'id'   => $u->id,
                'name' => $u->name,
            ]),
        ]);
    }

    public function detach(Issue $issue, User $user): JsonResponse
    {
        $issue->assignees()->detach($user->id);
        $issue->load('assignees');

        return response()->json([
            'assignees' => $issue->assignees->map(fn ($u) => [
                'id'   => $u->id,
                'name' => $u->name,
            ]),
        ]);
    }
}
