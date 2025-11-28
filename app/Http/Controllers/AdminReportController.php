<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['reporter', 'resolver'])
                        ->with(['reportable' => function($query) {
                            $query->morphWith([
                                Post::class => ['user', 'community'],
                                Comment::class => ['user', 'post'],
                                User::class => [],
                            ]);
                        }])
                        ->latest()
                        ->paginate(20);

        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'resolved' => Report::resolved()->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
            'critical' => Report::where('severity', 'critical')->where('status', 'pending')->count(),
            'today' => Report::whereDate('created_at', today())->count(),
        ];

        $severityCounts = [
            'critical' => Report::where('severity', 'critical')->where('status', 'pending')->count(),
            'high' => Report::where('severity', 'high')->where('status', 'pending')->count(),
            'medium' => Report::where('severity', 'medium')->where('status', 'pending')->count(),
            'low' => Report::where('severity', 'low')->where('status', 'pending')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats', 'severityCounts'));
    }

    public function show(Report $report)
    {
        $report->load(['reporter', 'resolver']);
        
        // Load morphable relation dengan eager loading yang sesuai
        if ($report->reportable_type === Post::class) {
            $report->load(['reportable.user', 'reportable.community']);
        } elseif ($report->reportable_type === Comment::class) {
            $report->load(['reportable.user', 'reportable.post.user']);
        } elseif ($report->reportable_type === User::class) {
            $report->load(['reportable']);
        }

        $similar_reports = Report::where('reportable_type', $report->reportable_type)
                                ->where('reportable_id', $report->reportable_id)
                                ->where('id', '!=', $report->id)
                                ->with('reporter')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.reports.show', compact('report', 'similar_reports'));
    }

    public function resolve(Request $request, Report $report)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
            'action' => 'required|in:resolve,dismiss'
        ]);

        if ($validated['action'] === 'resolve') {
            $report->markAsResolved(auth()->id(), $validated['admin_notes']);
            $message = 'Report resolved successfully.';
        } else {
            $report->markAsDismissed(auth()->id(), $validated['admin_notes']);
            $message = 'Report dismissed successfully.';
        }

        return back()->with('success', $message);
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
                        ->with('success', 'Report deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:resolve,dismiss,delete',
            'report_ids' => 'required|array',
            'report_ids.*' => 'exists:reports,id',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $action = $validated['action'];
        $reportIds = $validated['report_ids'];
        $adminNotes = $validated['admin_notes'];

        switch ($action) {
            case 'resolve':
                Report::whereIn('id', $reportIds)->update([
                    'status' => 'resolved',
                    'resolved_by' => auth()->id(),
                    'resolved_at' => now(),
                    'admin_notes' => $adminNotes
                ]);
                $message = 'Reports resolved successfully.';
                break;
                
            case 'dismiss':
                Report::whereIn('id', $reportIds)->update([
                    'status' => 'dismissed',
                    'resolved_by' => auth()->id(),
                    'resolved_at' => now(),
                    'admin_notes' => $adminNotes
                ]);
                $message = 'Reports dismissed successfully.';
                break;
                
            case 'delete':
                Report::whereIn('id', $reportIds)->delete();
                $message = 'Reports deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $reports = Report::with(['reporter', 'resolver'])
                        ->with(['reportable' => function($query) {
                            $query->morphWith([
                                Post::class => ['user'],
                                Comment::class => ['user'],
                                User::class => [],
                            ]);
                        }])
                        ->where(function($q) use ($query) {
                            $q->where('reason', 'like', "%{$query}%")
                              ->orWhereHas('reporter', function($q) use ($query) {
                                  $q->where('name', 'like', "%{$query}%")
                                    ->orWhere('username', 'like', "%{$query}%");
                              })
                              ->orWhereHas('reportable', function($q) use ($query) {
                                  $q->where(function($subQ) use ($query) {
                                      if (method_exists($subQ->getModel(), 'getTable')) {
                                          $table = $subQ->getModel()->getTable();
                                          if (in_array('title', $subQ->getModel()->getFillable())) {
                                              $subQ->where('title', 'like', "%{$query}%");
                                          }
                                          if (in_array('content', $subQ->getModel()->getFillable())) {
                                              $subQ->orWhere('content', 'like', "%{$query}%");
                                          }
                                          if (in_array('name', $subQ->getModel()->getFillable())) {
                                              $subQ->orWhere('name', 'like', "%{$query}%");
                                          }
                                      }
                                  });
                              });
                        })
                        ->latest()
                        ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    public function bySeverity($severity)
    {
        $reports = Report::with(['reporter', 'resolver'])
                        ->with(['reportable' => function($query) {
                            $query->morphWith([
                                Post::class => ['user'],
                                Comment::class => ['user'],
                                User::class => [],
                            ]);
                        }])
                        ->where('severity', $severity)
                        ->where('status', 'pending')
                        ->latest()
                        ->paginate(20);

        $stats = [
            'total' => Report::where('severity', $severity)->count(),
            'pending' => Report::where('severity', $severity)->where('status', 'pending')->count(),
        ];

        return view('admin.reports.severity', compact('reports', 'stats', 'severity'));
    }

    public function byStatus($status)
    {
        $reports = Report::with(['reporter', 'resolver'])
                        ->with(['reportable' => function($query) {
                            $query->morphWith([
                                Post::class => ['user'],
                                Comment::class => ['user'],
                                User::class => [],
                            ]);
                        }])
                        ->where('status', $status)
                        ->latest()
                        ->paginate(20);

        $stats = [
            'total' => Report::where('status', $status)->count(),
        ];

        return view('admin.reports.status', compact('reports', 'stats', 'status'));
    }

    public function reopen(Report $report)
    {
        $report->reopen();

        return back()->with('success', 'Report reopened successfully.');
    }

    public function updateSeverity(Request $request, Report $report)
    {
        $validated = $request->validate([
            'severity' => 'required|in:low,medium,high,critical'
        ]);

        $report->update(['severity' => $validated['severity']]);

        return back()->with('success', 'Report severity updated successfully.');
    }
}