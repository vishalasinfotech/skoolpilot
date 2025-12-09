@extends('layouts.master')
@section('title', 'Bulk Import Staff')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Bulk Import Staff</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('school-admin.staff.index') }}">Staff</a></li>
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
                            <h5 class="card-title mb-0">Import Staff from CSV/Excel</h5>
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
                                    <li>Upload a CSV file with staff data</li>
                                    <li>First row should contain column headers</li>
                                    <li>Maximum file size: 5MB</li>
                                    <li>Date format: YYYY-MM-DD (e.g., 2024-01-15)</li>
                                </ul>
                            </div>

                            <form action="{{ route('school-admin.staff.process-bulk-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="school_id" class="form-label">Select School <span class="text-danger">*</span></label>
                                    <x-select name="school_id" id="school_id" :options="$schools" :value="old('school_id')" required placeholder="Select School" />
                                    @error('school_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                    <small class="text-muted">All imported staff will be assigned to this school</small>
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
                                                        <th>employee_number</th>
                                                        <th>phone</th>
                                                        <th>gender</th>
                                                        <th>date_of_birth</th>
                                                        <th>designation</th>
                                                        <th>department</th>
                                                        <th>joining_date</th>
                                                        <th>address</th>
                                                        <th>qualification</th>
                                                        <th>emergency_contact</th>
                                                        <th>is_active</th>
                                                        <th>doc_type</th>
                                                        <th>doc_image</th>
                                                        <th>password</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Alice</td>
                                                        <td>Johnson</td>
                                                        <td>alice.johnson@example.com</td>
                                                        <td>EMP001</td>
                                                        <td>5551234567</td>
                                                        <td>female</td>
                                                        <td>1985-04-18</td>
                                                        <td>Teacher</td>
                                                        <td>Mathematics</td>
                                                        <td>2022-09-01</td>
                                                        <td>900 Apple Street</td>
                                                        <td>M.Sc., B.Ed.</td>
                                                        <td>5559876543</td>
                                                        <td>1</td>
                                                        <td>aadhar</td>
                                                        <td>https://example.com/doc_image.jpg</td>
                                                        <td>password</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <strong>Notes:</strong>
                                                <ul class="mb-0">
                                                    <li>Required fields: first_name, last_name, email, employee_number</li>
                                                    <li>Gender values: male, female, other</li>
                                                    <li>is_active: 1 for active, 0 for inactive</li>
                                                    <li>Empty fields will be stored as NULL</li>
                                                    <li>doc_type: aadhar, pancard, other</li>
                                                    <li>doc_image: URL of the document image</li>
                                                    <li>password: password for the staff</li>
                                                </ul>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('school-admin.staff.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-upload-line me-1"></i> Import Staff
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
            const csvContent = "first_name,last_name,email,employee_number,phone,gender,date_of_birth,designation,department,joining_date,address,qualification,emergency_contact,is_active,doc_type,doc_image,password\n" +
                              "Alice,Johnson,alice.johnson@example.com,EMP001,5551234567,female,1985-04-18,Teacher,Mathematics,2022-09-01,900 Apple Street,M.Sc., B.Ed.,5559876543,1\n" +
                              "Bob,Williams,bob.williams@example.com,EMP002,5557654321,male,1979-12-02,Admin,Administration,2020-03-20,1200 Orange Ave,B.A.,5551239876,1";

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);

            link.setAttribute("href", url);
            link.setAttribute("download", "staff_sample.csv");
            link.style.visibility = 'hidden';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    @endpush
@endsection

