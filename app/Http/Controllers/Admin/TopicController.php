<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Subtopic;
use App\Models\TopicActivity;  // Add this line
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $query = Topic::with(['subject', 'subtopics', 'activities']);

        // Apply filters
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }

        $topics = $query->latest()->get();
        $subjects = Subject::all();

        return view('admin.subjects.topics.index', compact('topics', 'subjects'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'subject_id' => 'required|exists:subjects,id',
                'name' => 'required|string|max:255',
                'duration' => 'required|in:1 Week,2 Weeks,3 Weeks,4 Weeks,1 Month,2 Months,Term',
                'class_level' => 'required|string|max:255',  // Add this line
                'subtopics' => 'required|array|min:1|max:4',
                'subtopics.*' => 'required|string|max:255',
                'activities' => 'nullable|array',
                'activities.*.type' => 'required|in:Assignment,Quiz,Homework',
                'activities.*.title' => 'required|string|max:255'
            ]);

            \DB::beginTransaction();

            // Create topic with class_level
            $topic = Topic::create([
                'subject_id' => $validated['subject_id'],
                'name' => $validated['name'],
                'duration' => $validated['duration'],
                'class_level' => $validated['class_level']  // Add this line
            ]);

            // Create subtopics
            foreach ($validated['subtopics'] as $index => $subtopicName) {
                if (!empty($subtopicName)) {
                    $topic->subtopics()->create([
                        'name' => $subtopicName,
                        'order' => $index + 1
                    ]);
                }
            }

            // Create activities
            if (!empty($validated['activities'])) {
                foreach ($validated['activities'] as $activity) {
                    if (!empty($activity['title'])) {
                        $topic->activities()->create([
                            'type' => $activity['type'],
                            'title' => $activity['title']
                        ]);
                    }
                }
            }

            \DB::commit();

            return redirect()->route('admin.subjects.topics.index')
                ->with('success', 'Topic created successfully!');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error creating topic: ' . $e->getMessage()]);
        }
    }

    public function show(Topic $topic)
    {
        $topic->load(['subject', 'subtopics', 'activities']);
        return response()->json($topic);
    }

    public function edit(Topic $topic)
    {
        try {
            // Load relationships
            $topic->load(['subject', 'subtopics', 'activities']);

            // Debug log
            \Log::debug('Edit Topic Data:', ['topic' => $topic->toArray()]);

            $data = [
                'id' => $topic->id,
                'subject_id' => $topic->subject_id,
                'name' => $topic->name,
                'class_level' => $topic->class_level,
                'duration' => $topic->duration,
                'subtopics' => $topic->subtopics->map(function($subtopic) {
                    return [
                        'id' => $subtopic->id,
                        'name' => $subtopic->name,
                        'order' => $subtopic->order
                    ];
                })->values(),
                'activities' => $topic->activities->map(function($activity) {
                    return [
                        'id' => $activity->id,
                        'type' => $activity->type,
                        'title' => $activity->title
                    ];
                })->values()
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Edit Topic Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'duration' => 'required|in:1 Week,2 Weeks,3 Weeks,4 Weeks,1 Month,2 Months,Term',
            'subtopics' => 'required|array|min:1|max:4',
            'subtopics.*' => 'required|string|max:255',
            'activities' => 'nullable|array',
            'activities.*.type' => 'required|in:Assignment,Quiz,Homework',
            'activities.*.title' => 'required|string|max:255'
        ]);

        $topic->update([
            'subject_id' => $validated['subject_id'],
            'name' => $validated['name'],
            'duration' => $validated['duration']
        ]);

        // Update subtopics
        $topic->subtopics()->delete();
        foreach ($validated['subtopics'] as $index => $subtopicName) {
            $topic->subtopics()->create([
                'name' => $subtopicName,
                'order' => $index + 1
            ]);
        }

        // Update activities
        $topic->activities()->delete();
        if (!empty($validated['activities'])) {
            foreach ($validated['activities'] as $activity) {
                $topic->activities()->create([
                    'type' => $activity['type'],
                    'title' => $activity['title']
                ]);
            }
        }

        return redirect()->route('admin.subjects.topics.index')
            ->with('success', 'Topic updated successfully!');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.subjects.topics.index')
            ->with('success', 'Topic deleted successfully!');
    }
}