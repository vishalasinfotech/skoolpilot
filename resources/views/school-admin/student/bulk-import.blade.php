@extends('layouts.master')
@section('title', 'Bulk Import Students')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Bulk Import Students</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.student.index') }}">Students</a></li>
                                <li class="breadcrumb-item active">Bulk Import</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Import Students from CSV/Excel</h5>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="ri-check-line me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Import Instructions</h6>
                                <ul class="mb-0">
                                    <li>Upload a CSV file with student data</li>
                                    <li>First row should contain column headers</li>
                                    <li>Maximum file size: 5MB</li>
                                    <li>Date format: YYYY-MM-DD (e.g., 2024-01-15)</li>
                                </ul>
                            </div>

                            <form action="{{ route('school-admin.student.process-bulk-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="school_id" class="form-label">Select School <span class="text-danger">*</span></label>
                                    <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id')" required placeholder="Select School" />
                                    @error('school_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                    <small class="text-muted">All imported students will be assigned to this school</small>
                                </div>

                                <div class="mb-4">
                                    <label for="file" class="form-label">Upload CSV File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file" accept=".csv,.xlsx,.xls" required>
                                    @error('file')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">Required CSV Format</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>first_name</th>
                                                        <th>last_name</th>
                                                        <th>email</th>
                                                        <th>admission_number</th>
                                                        <th>phone</th>
                                                        <th>gender</th>
                                                        <th>date_of_birth</th>
                                                        <th>class</th>
                                                        <th>section</th>
                                                        <th>admission_date</th>
                                                        <th>address</th>
                                                        <th>parent_name</th>
                                                        <th>parent_phone</th>
                                                        <th>is_active</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>John</td>
                                                        <td>Doe</td>
                                                        <td>john@example.com</td>
                                                        <td>ADM001</td>
                                                        <td>1234567890</td>
                                                        <td>male</td>
                                                        <td>2010-05-15</td>
                                                        <td>10</td>
                                                        <td>B</td>
                                                        <td>2024-01-01</td>
                                                        <td>123 Main St</td>
                                                        <td>Jane Doe</td>
                                                        <td>9876543210</td>
                                                        <td>1</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <strong>Notes:</strong>
                                                <ul class="mb-0">
                                                    <li>Required fields: first_name, last_name, email, admission_number</li>
                                                    <li>Gender values: male, female, other</li>
                                                    <li>is_active: 1 for active, 0 for inactive</li>
                                                    <li>Empty fields will be stored as NULL</li>
                                                </ul>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('school-admin.student.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-upload-line me-1"></i> Import Students
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Download Sample CSV -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Need a sample CSV file?</h6>
                            <p class="text-muted mb-3">Download a sample CSV template to get started quickly.</p>
                            <a href="#" class="btn btn-outline-success" onclick="downloadSampleCSV(); return false;">
                                <i class="ri-download-line me-1"></i> Download Sample CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function downloadSampleCSV() {
            const csvContent = "first_name,last_name,email,admission_number,phone,gender,date_of_birth,class,section,admission_date,address,parent_name,parent_phone,is_active\n" +
                              "John,Doe,john@example.com,ADM001,1234567890,male,2010-05-15,10,B,2024-01-01,123 Main St,Jane Doe,9876543210,1\n" +
                              "Jane,Smith,jane@example.com,ADM002,0987654321,female,2011-08-20,9,A,2024-01-01,456 Oak Avenue,John Smith,8765432109,1";

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);

            link.setAttribute("href", url);
            link.setAttribute("download", "students_sample.csv");
            link.style.visibility = 'hidden';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    @endpush
@endsection

