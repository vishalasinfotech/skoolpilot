@extends('layouts.master')
@section('title', 'Edit Result')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Result</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.result.index') }}">Results</a></li>
                                <li class="breadcrumb-item active">Edit Result</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Edit Result</h5>
                            <a href="{{ route('school-admin.result.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            @include('layouts.badge')
                            <form action="{{ route('school-admin.result.update', $result->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                                        <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id', $result->school_id)" required placeholder="Select School" />
                                        @error('school_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_session_id" class="form-label">Academic Session <span class="text-danger">*</span></label>
                                        <x-select name="academic_session_id" id="academic_session_id" :options="$academicSessions" :value="old('academic_session_id', $result->academic_session_id)" required placeholder="Select Academic Session" />
                                        @error('academic_session_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="exam_id" class="form-label">Exam <span class="text-danger">*</span></label>
                                        <x-select name="exam_id" id="exam_id" :options="$exams" :value="old('exam_id', $result->exam_id)" required placeholder="Select Exam" />
                                        @error('exam_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exam_schedule_id" class="form-label">Exam Schedule <span class="text-danger">*</span></label>
                                        <x-select name="exam_schedule_id" id="exam_schedule_id" :options="$examSchedules" :value="old('exam_schedule_id', $result->exam_schedule_id)" required placeholder="Select Exam Schedule" />
                                        @error('exam_schedule_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                                        <x-select name="student_id" id="student_id" :options="$students" :value="old('student_id', $result->student_id)" required placeholder="Select Student" />
                                        @error('student_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="academic_class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                        <x-select name="academic_class_id" id="academic_class_id" :options="$classes" :value="old('academic_class_id', $result->academic_class_id)" required placeholder="Select Class" />
                                        @error('academic_class_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="section_id" class="form-label">Section</label>
                                        <x-select name="section_id" id="section_id" :options="$sections" :value="old('section_id', $result->section_id)" placeholder="Select Section (Optional)" />
                                        @error('section_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <x-select name="subject_id" id="subject_id" :options="$subjects" :value="old('subject_id', $result->subject_id)" required placeholder="Select Subject" />
                                        @error('subject_id')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                                        <x-input type="number" name="total_marks" id="total_marks" :value="old('total_marks', $result->total_marks)" min="1" step="0.01" required />
                                        @error('total_marks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="obtained_marks" class="form-label">Obtained Marks <span class="text-danger">*</span></label>
                                        <x-input type="number" name="obtained_marks" id="obtained_marks" :value="old('obtained_marks', $result->obtained_marks)" min="0" step="0.01" required />
                                        <small class="text-muted">Percentage and grade will be calculated automatically</small>
                                        @error('obtained_marks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="pass" {{ old('status', $result->status) === 'pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="fail" {{ old('status', $result->status) === 'fail' ? 'selected' : '' }}>Fail</option>
                                            <option value="absent" {{ old('status', $result->status) === 'absent' ? 'selected' : '' }}>Absent</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="grade" class="form-label">Grade</label>
                                        <select name="grade" id="grade" class="form-select">
                                            <option value="">Select Grade</option>
                                            <option value="A+" {{ old('grade', $result->grade) === 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A" {{ old('grade', $result->grade) === 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B+" {{ old('grade', $result->grade) === 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B" {{ old('grade', $result->grade) === 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C+" {{ old('grade', $result->grade) === 'C+' ? 'selected' : '' }}>C+</option>
                                            <option value="C" {{ old('grade', $result->grade) === 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ old('grade', $result->grade) === 'D' ? 'selected' : '' }}>D</option>
                                            <option value="F" {{ old('grade', $result->grade) === 'F' ? 'selected' : '' }}>F</option>
                                        </select>
                                        @error('grade')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="percentage" class="form-label">Percentage</label>
                                        <x-input type="number" name="percentage" id="percentage" :value="old('percentage', $result->percentage)" min="0" max="100" step="0.01" placeholder="Auto-calculated" />
                                        @error('percentage')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <x-textarea name="remarks" id="remarks" rows="3" placeholder="Enter remarks">{{ old('remarks', $result->remarks) }}</x-textarea>
                                        @error('remarks')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">Update Result</button>
                                    <a href="{{ route('school-admin.result.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const obtainedMarks = document.getElementById('obtained_marks');
            const totalMarks = document.getElementById('total_marks');
            const percentage = document.getElementById('percentage');
            const grade = document.getElementById('grade');
            const status = document.getElementById('status');

            function calculateResult() {
                const obtained = parseFloat(obtainedMarks.value) || 0;
                const total = parseFloat(totalMarks.value) || 100;
                
                if (total > 0) {
                    const percent = (obtained / total) * 100;
                    percentage.value = percent.toFixed(2);

                    // Auto-set grade based on percentage
                    if (percent >= 90) grade.value = 'A+';
                    else if (percent >= 80) grade.value = 'A';
                    else if (percent >= 70) grade.value = 'B+';
                    else if (percent >= 60) grade.value = 'B';
                    else if (percent >= 50) grade.value = 'C+';
                    else if (percent >= 40) grade.value = 'C';
                    else if (percent >= 33) grade.value = 'D';
                    else grade.value = 'F';

                    // Auto-set status
                    if (percent >= 33) {
                        status.value = 'pass';
                    } else {
                        status.value = 'fail';
                    }
                }
            }

            obtainedMarks.addEventListener('input', calculateResult);
            totalMarks.addEventListener('input', calculateResult);
        });
    </script>
@endsection

