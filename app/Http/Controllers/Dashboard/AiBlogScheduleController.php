<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AiBlogSchedule;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AiBlogScheduleController extends Controller
{
    public function index()
    {
        $schedules = AiBlogSchedule::with('category')->orderBy('run_time')->get();
        $categories = Category::where('is_active', 'active')->orderBy('name')->get();

        return view('dashboard.ai-blog.schedules', compact('schedules', 'categories'));
    }

    public function store(Request $request)
    {
        if (!Gate::any(['update setting', 'create setting'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'run_time' => 'required|date_format:H:i',
            'post_count' => 'required|integer|min:1|max:20',
            'category_id' => 'nullable|exists:categories,id',
            'trend_country' => 'nullable|string|max:10',
        ]);

        AiBlogSchedule::create([
            'run_time' => $request->run_time . ':00',
            'post_count' => $request->post_count,
            'category_id' => $request->category_id ?: null,
            'trend_country' => $request->trend_country ?: null,
            'is_enabled' => true,
        ]);

        return redirect()->route('dashboard.ai_blog.schedules.index')->with('success', 'Time slot added successfully.');
    }

    public function update(Request $request, AiBlogSchedule $schedule)
    {
        if (!Gate::any(['update setting', 'create setting'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'run_time' => 'required|date_format:H:i',
            'post_count' => 'required|integer|min:1|max:20',
            'category_id' => 'nullable|exists:categories,id',
            'trend_country' => 'nullable|string|max:10',
        ]);

        $schedule->update([
            'run_time' => $request->run_time . ':00',
            'post_count' => $request->post_count,
            'category_id' => $request->category_id ?: null,
            'trend_country' => $request->trend_country ?: null,
        ]);

        return redirect()->route('dashboard.ai_blog.schedules.index')->with('success', 'Time slot updated successfully.');
    }

    public function toggle(AiBlogSchedule $schedule)
    {
        $schedule->update(['is_enabled' => !$schedule->is_enabled]);

        return redirect()->route('dashboard.ai_blog.schedules.index')->with('success', 'Time slot updated.');
    }

    public function destroy(AiBlogSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('dashboard.ai_blog.schedules.index')->with('success', 'Time slot removed.');
    }
}
