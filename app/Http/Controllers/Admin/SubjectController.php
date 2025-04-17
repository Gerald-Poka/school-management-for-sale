<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Traits\SubjectManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    use SubjectManagement;

    public function index(Request $request)
    {
        $query = Subject::query();

        // Apply filters if they exist
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('credits_min')) {
            $query->where('credits', '>=', $request->credits_min);
        }

        if ($request->filled('credits_max')) {
            $query->where('credits', '<=', $request->credits_max);
        }

        $subjects = $query->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = $this->getSubjectsPerLevel();
        $standards = array_keys($subjects);
        return view('admin.subjects.create', compact('subjects', 'standards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:Standard 1,Standard 2,Standard 3,Standard 4,Standard 5,Standard 6',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:0',
            'pdf_link' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        // Generate unique code
        $validated['code'] = $this->generateSubjectCode($validated['name'], $validated['level']);

        if ($request->hasFile('pdf_link')) {
            $file = $request->file('pdf_link');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subjects'), $filename);
            $validated['pdf_link'] = 'uploads/subjects/' . $filename;
        }

        Subject::create($validated);
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully!');
    }

    public function edit(Subject $subject)
    {
        $standards = ['Standard 1', 'Standard 2', 'Standard 3', 'Standard 4', 'Standard 5', 'Standard 6'];
        return view('admin.subjects.edit', compact('subject', 'standards'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:0',
            'level' => 'required|in:Standard 1,Standard 2,Standard 3,Standard 4,Standard 5,Standard 6',
            'pdf_link' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        if ($request->hasFile('pdf_link')) {
            // Delete old file if exists
            if ($subject->pdf_link && file_exists(public_path($subject->pdf_link))) {
                unlink(public_path($subject->pdf_link));
            }

            $file = $request->file('pdf_link');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subjects'), $filename);
            $validated['pdf_link'] = 'uploads/subjects/' . $filename;
        }

        $subject->update($validated);
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully!');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->pdf_link && file_exists(public_path($subject->pdf_link))) {
            unlink(public_path($subject->pdf_link));
        }
        $subject->delete();
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully!');
    }

    public function standard($level)
    {
        $subjects = Subject::where('level', 'Standard ' . $level)->get();
        return view('admin.subjects.standard', compact('subjects', 'level'));
    }

    public function topics()
    {
        return view('admin.subjects.topics');
    }

    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }
}