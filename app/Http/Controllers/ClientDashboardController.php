<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;

        // Get client's data
        $projects = $client->projects()->with(['messages' => function($query) {
            $query->latest()->limit(3);
        }])->latest()->get();

        $orders = $client->orders()->with('service')->latest()->take(5)->get();

        $recentMessages = $client->projects()
            ->join('project_messages', 'projects.id', '=', 'project_messages.project_id')
            ->where('project_messages.sender_id', '!=', Auth::id())
            ->select('project_messages.*', 'projects.title as project_title')
            ->orderBy('project_messages.created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_projects' => $client->projects()->count(),
            'active_projects' => $client->projects()->where('status', 'in_progress')->count(),
            'completed_projects' => $client->projects()->where('status', 'completed')->count(),
            'total_orders' => $client->orders()->count(),
        ];

        return view('client-dashboard.index', compact('projects', 'orders', 'recentMessages', 'stats'));
    }

    public function project($id)
    {
        $client = Auth::user()->client;
        $project = $client->projects()->findOrFail($id);

        $messages = $project->messages()->with('sender')->orderBy('created_at', 'desc')->get();
        $files = $project->files()->with('uploader')->orderBy('created_at', 'desc')->get();

        return view('client-dashboard.project', compact('project', 'messages', 'files'));
    }

    public function sendMessage(Request $request, $projectId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $client = Auth::user()->client;
        $project = $client->projects()->findOrFail($projectId);

        ProjectMessage::create([
            'project_id' => $project->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function uploadFile(Request $request, $projectId)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $client = Auth::user()->client;
        $project = $client->projects()->findOrFail($projectId);

        $file = $request->file('file');
        $path = $file->store('project-files', 'public');

        ProjectFile::create([
            'project_id' => $project->id,
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function downloadFile($fileId)
    {
        $client = Auth::user()->client;
        $file = ProjectFile::whereHas('project', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->findOrFail($fileId);

        return Storage::disk('public')->download($file->file_path);
    }
}
