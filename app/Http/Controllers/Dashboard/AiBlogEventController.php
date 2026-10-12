<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AiBlogEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AiBlogEventController extends Controller
{
    public function index()
    {
        $events = AiBlogEvent::orderBy('event_date')->get();

        return view('dashboard.ai-blog.events', compact('events'));
    }

    public function store(Request $request)
    {
        if (!Gate::any(['update setting', 'create setting'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => 'required|string|max:120',
            'event_date' => 'required|date',
        ]);

        AiBlogEvent::create($data + ['is_active' => true]);

        return redirect()->route('dashboard.ai_blog.events.index')->with('success', 'Event added.');
    }

    public function toggle(AiBlogEvent $event)
    {
        if (!Gate::any(['update setting', 'create setting'])) {
            abort(403, 'Unauthorized');
        }

        $event->update(['is_active' => !$event->is_active]);

        return redirect()->route('dashboard.ai_blog.events.index')->with('success', 'Event updated.');
    }

    public function destroy(AiBlogEvent $event)
    {
        if (!Gate::any(['update setting', 'create setting'])) {
            abort(403, 'Unauthorized');
        }

        $event->delete();

        return redirect()->route('dashboard.ai_blog.events.index')->with('success', 'Event removed.');
    }
}
