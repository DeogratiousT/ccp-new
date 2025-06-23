<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Probe;
use App\Models\Section;
use App\Models\Condition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\ProbesDataTable;
use App\Http\Controllers\Controller;
use App\Actions\Generate\UniqueStringGenerator;

class ProbeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Section $section)
    {
        return view('dashboard.probes.index', [
            'section' => $section,
            'probes' => $section->probes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Section $section)
    {
        return view('dashboard.probes.create', [
            'section' => $section,
            'conditions' => Condition::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Section $section)
    {
        $validated = $request->validate([
            'rabbitmq_queue' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
            'condition_id' => ['required', 'integer'],
            'max_threshold' => ['nullable', 'string'],
            'min_threshold' => ['nullable', 'string'],
            'description' => ['nullable', 'string']
        ]);

        $validated['uuid'] = (string) Str::uuid();

        try {
            Probe::create($validated);

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Added Successfully');
        } catch (\Throwable $th) {
            logger('Probe Add Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Section $section, Probe $probe)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section, Probe $probe)
    {
        return view('dashboard.probes.edit', [
            'section' => $section,
            'probe' => $probe,
            'conditions' => Condition::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section, Probe $probe)
    {
        $validated = $request->validate([
            'rabbitmq_queue' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
            'condition_id' => ['required', 'integer'],
            'max_threshold' => ['nullable', 'string'],
            'min_threshold' => ['nullable', 'string'],
            'description' => ['required', 'string']
        ]);

        try {
            $probe->update($validated);

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Updated Successfully');
        } catch (\Throwable $th) {
            logger('Probe Update Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Probe $probe)
    {
        try {
            $probe->delete();

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Probe Delete Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
