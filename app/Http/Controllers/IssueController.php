<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function create(Project $project): View
    {
        return view('issues.create', compact('project'));
    }

    public function store(StoreIssueRequest $request, Project $project): RedirectResponse
    {
        $project->issues()->create($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Issue created.');
    }

    public function show(Issue $issue): View
    {
        $issue->load(['project', 'tags', 'assignees']);
        $allTags = Tag::orderBy('name')->get();
        $allUsers = User::orderBy('name')->get();

        return view('issues.show', compact('issue', 'allTags', 'allUsers'));
    }

    public function edit(Issue $issue): View
    {
        return view('issues.edit', compact('issue'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()->route('issues.show', $issue)->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $project = $issue->project;
        $issue->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Issue deleted.');
    }
}
