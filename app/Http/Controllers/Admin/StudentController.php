<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AcademicLevel;
use App\Models\User;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['academicLevel', 'guardian'])
            ->orderBy('admission_number')
            ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        $newAdmissionNumber = Student::generateAdmissionNumber();
        return view('admin.students.create', compact('academicLevels', 'newAdmissionNumber'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Log the start of student creation
            \Log::info('Starting student creation process');

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'academic_level_id' => 'required|exists:academic_levels,id',
                'special_needs' => 'nullable|string',
                'date_of_admission' => 'required|date',
                'guardian_full_name' => 'required|string|max:255',
                'guardian_relationship' => 'required|string|max:255',
                'guardian_primary_phone' => 'required|string|max:255',
                'guardian_alternative_phone' => 'nullable|string|max:255',
                'guardian_email' => 'required|email|unique:users,email',
                'guardian_residential_address' => 'required|string|max:255',
                'guardian_occupation' => 'required|string|max:255',
            ]);

            // Generate unique admission number
            \Log::info('Generating admission number');
            $admissionNumber = Student::generateAdmissionNumber();
            \Log::info('Generated admission number', ['number' => $admissionNumber]);

            // Double check username uniqueness
            if (User::where('username', $admissionNumber)->exists()) {
                \Log::error('Username already exists after generation', ['username' => $admissionNumber]);
                throw new \Exception('Failed to generate unique admission number. Please try again.');
            }

            // Log guardian creation
            \Log::info('Creating guardian record', [
                'email' => $validated['guardian_email']
            ]);

            // Create guardian record
            $guardian = Guardian::create([
                'full_name' => $validated['guardian_full_name'],
                'relationship' => $validated['guardian_relationship'],
                'primary_phone' => $validated['guardian_primary_phone'],
                'alternative_phone' => $validated['guardian_alternative_phone'],
                'email' => $validated['guardian_email'], // Guardian's email
                'residential_address' => $validated['guardian_residential_address'],
                'occupation' => $validated['guardian_occupation'],
                'is_emergency_contact' => $request->has('is_emergency_contact')
            ]);

            // Log user creation attempt
            \Log::info('Attempting to create user account', [
                'username' => $admissionNumber,
                'email' => $validated['guardian_email']
            ]);

            // Create user account for student using guardian's email
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'username' => $admissionNumber, // Use admission number as username
                'email' => $validated['guardian_email'], // Use guardian's email for login
                'password' => Hash::make($validated['last_name']),
                'role' => 'student',
                'is_active' => true
            ]);

            // Log successful user creation
            \Log::info('User created successfully', ['user_id' => $user->id]);

            // Handle profile picture upload
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')
                    ->store('student-photos', 'public');
            }

            // Create student record
            $student = Student::create([
                'user_id' => $user->id,
                'guardian_id' => $guardian->id,
                'admission_number' => $admissionNumber,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'academic_level_id' => $validated['academic_level_id'],
                'special_needs' => $validated['special_needs'],
                'date_of_admission' => $validated['date_of_admission'],
                'profile_picture' => $profilePicturePath,
                'is_active' => true,
            ]);

            DB::commit();
            \Log::info('Student creation completed successfully');

            return redirect()->route('admin.students.index')
                ->with('success', "Student created successfully!\n" .
                                "Admission Number: {$admissionNumber}\n" .
                                "Login Email: {$validated['guardian_email']}\n" .
                                "Default Password: {$validated['last_name']}");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Student creation error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);
            return back()
                ->withErrors(['error' => 'Error creating student: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        return view('admin.students.edit', compact('student', 'academicLevels'));
    }

    public function update(Request $request, Student $student)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'academic_level_id' => 'required|exists:academic_levels,id',
                'special_needs' => 'nullable|string|max:500',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_active' => 'nullable|boolean'
            ]);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($student->profile_picture) {
                    Storage::disk('public')->delete($student->profile_picture);
                }
                
                $validated['profile_picture'] = $request->file('profile_picture')
                    ->store('student-photos', 'public');
            }

            // Update is_active status
            $validated['is_active'] = $request->has('is_active');

            // Update student record
            $student->update($validated);

            // Also update user active status
            $student->user()->update([
                'is_active' => $validated['is_active']
            ]);

            DB::commit();

            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Student updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Student update error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error updating student: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('admin.students.index')
                ->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting student: ' . $e->getMessage());
        }
    }
}