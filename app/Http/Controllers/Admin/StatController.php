<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StatRequest;
use App\Models\Stat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatController extends Controller
{
    public function index(): View
    {
        $stats = Stat::orderBy('sort_order', 'asc')->get();

        return view('admin.stats.index', compact('stats'));
    }

    public function create(): View
    {
        return view('admin.stats.create');
    }

    public function store(StatRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (Stat::max('sort_order') + 1);

        Stat::create($validated);

        return redirect()->route('admin.stats.index')
            ->with('success', 'Key figure stat created successfully.');
    }

    public function edit(Stat $stat): View
    {
        return view('admin.stats.edit', compact('stat'));
    }

    public function update(StatRequest $request, Stat $stat): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        $stat->update($validated);

        return redirect()->route('admin.stats.index')
            ->with('success', 'Key figure stat updated successfully.');
    }

    public function destroy(Stat $stat): RedirectResponse
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')
            ->with('success', 'Key figure stat deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:stats,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Stat::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Key figures order updated successfully.',
        ]);
    }
}
