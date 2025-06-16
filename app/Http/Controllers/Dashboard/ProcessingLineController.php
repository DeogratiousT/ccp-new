<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProcessingLine;
use App\Http\Controllers\Controller;

class ProcessingLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.processinglines.index', [
            'processingLines' => ProcessingLine::all()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.processinglines.create', [
            'sections' => Section::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => ['required', 'integer'],
            'description' => ['required', 'string']
        ]);

        $validated['uuid'] = (string) Str::uuid();

        try {
            ProcessingLine::create($validated);

            return to_route('dashboard.processinglines.index')->with('success', 'Processing Line Added Succesfully');
        } catch (\Throwable $th) {
            logger('Processing Line Add Failed: ' . $th->getMessage());

            return to_route('dashboard.processinglines.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcessingLine $processingLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $processingLine = ProcessingLine::findOrFail($id);

        return view('dashboard.processinglines.edit', [
            'processingLine' => $processingLine,
            'sections' => Section::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $processingLine = ProcessingLine::findOrFail($id);

        $validated = $request->validate([
            'section_id' => ['required', 'integer'],
            'description' => ['required', 'string']
        ]);

        try {
            $processingLine->update($validated);

            return to_route('dashboard.processinglines.index')->with('success', 'Processing Line Updated Succesfully');
        } catch (\Throwable $th) {
            logger('Processing Line Update Failed: ' . $th->getMessage());

            return to_route('dashboard.processinglines.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $processingLine = ProcessingLine::findOrFail($id);

        try {
            $processingLine->delete();

            return to_route('dashboard.processinglines.index')->with('success', 'Processing Lines Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Processing Lines Delete Failed: ' . $th->getMessage());

            return to_route('dashboard.processinglines.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
