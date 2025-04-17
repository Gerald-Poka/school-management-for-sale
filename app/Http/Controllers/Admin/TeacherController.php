<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $employeeId = $this->generateEmployeeId();
        return view('admin.teachers.create', compact('employeeId'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the request first to ensure we have valid employee_id
            $validated = $request->validate([
                'employee_id' => 'required|unique:teachers,employee_id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'date_of_birth' => 'required|date',
                'birth_certificate_number' => 'required|string|max:255',
                'national_id' => 'required|string|max:255|unique:teachers,national_id',
                'passport_number' => 'required|string|max:255',
                'phone' => 'required|string|max:255|unique:teachers,phone',
                'alternative_phone' => 'required|string|max:255',
                'email' => 'required|email|unique:teachers,email',
                'physical_address' => 'required|string',
                'postal_address' => 'required|string',
                'highest_qualification' => 'required|string|max:255',
                'specialization' => 'required|string|max:255',
                'joining_date' => 'required|date',
                'teaching_license_number' => 'required|string',
                'license_expiry_date' => 'required|date',
                
                // File uploads
                'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'teaching_license' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'certificates' => 'required|file|mimes:pdf|max:2048',
                'recommendation_letters' => 'required|file|mimes:pdf|max:2048',
                'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // Handle file uploads
            $filePaths = [];
            $fileFields = ['cv', 'teaching_license', 'certificates', 'recommendation_letters', 'id_document', 'birth_certificate'];
            
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $file->store('teacher-documents', 'public');
                    $filePaths[$field . '_path'] = $path;
                }
            }

            // Create user account with employee_id as username
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'username' => $request->employee_id, // Use employee_id as username
                'password' => Hash::make('password123'),
                'role' => 'teacher'
            ]);

            // Create teacher with validated data
            $teacher = Teacher::create(array_merge(
                $validated,
                $filePaths,
                [
                    'user_id' => $user->id,
                    'is_active' => true,
                    'subjects_taught' => $request->subjects_taught ?? [],
                    'ict_skills' => $request->ict_skills ?? []
                ]
            ));

            DB::commit();
            
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', 'Teacher registered successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Teacher registration error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        try {
            $validated = $request->validate([
                'phone' => 'required|string|max:20',
                'alternative_phone' => 'nullable|string|max:20',
                'physical_address' => 'required|string',
                'postal_address' => 'nullable|string',
                'teaching_license_number' => 'nullable|string|max:255',
                'license_expiry_date' => 'nullable|date',
                'is_active' => 'required|boolean',
            ]);

            // Handle file uploads if present
            if ($request->hasFile('cv')) {
                $validated['cv_path'] = $request->file('cv')->store('teachers/cvs', 'public');
            }
            if ($request->hasFile('teaching_license')) {
                $validated['teaching_license_path'] = $request->file('teaching_license')->store('teachers/licenses', 'public');
            }
            if ($request->hasFile('certificates')) {
                $validated['certificates_path'] = $request->file('certificates')->store('teachers/certificates', 'public');
            }

            // Update teacher information
            try {
                $teacher->update($validated);
            } catch (\Exception $e) {
                \Log::error('Teacher update failed: ' . $e->getMessage());
                return back()->withInput()
                    ->with('error', 'Database update failed: ' . $e->getMessage());
            }

            return redirect()->route('admin.teachers.show', $teacher->id)
                ->with('success', 'Teacher information updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            \Log::error('Unexpected error in teacher update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    private function handleFileUploads(Request $request): array
    {
        $paths = [];
        $fileFields = [
            'cv' => 'cv_path',
            'teaching_license' => 'teaching_license_path',
            'certificates' => 'certificates_path',
            'recommendation_letters' => 'recommendation_letters_path',
            'id_document' => 'id_document_path',
            'birth_certificate' => 'birth_certificate_path'
        ];

        foreach ($fileFields as $field => $pathField) {
            if ($request->hasFile($field)) {
                $paths[$pathField] = $request->file($field)->store('teachers/' . $field . 's');
            }
        }

        return $paths;
    }

    private function generateEmployeeId(): string
    {
        $year = date('Y');
        $prefix = 'TCH';
        
        // Get the last teacher record
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        
        if (!$lastTeacher) {
            // If no teachers exist, start with 0001
            $number = '0001';
        } else {
            // Extract the numeric part and increment
            $lastNumber = intval(substr($lastTeacher->employee_id, -4));
            $number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }
        
        return $prefix . $year . $number;
    }
}