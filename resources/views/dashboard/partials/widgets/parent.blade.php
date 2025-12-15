{{-- Parent Widgets --}}
@if(isset($data['children']) && $data['children']->count() > 0)
<div class="row">
    @foreach($data['children'] as $child)
        <div class="col-xl-4 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ $child->name }}</p>
                            <small class="text-muted">{{ $child->admission_number ?? 'N/A' }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                Class: {{ $child->academicClass->name ?? 'N/A' }}
                            </h4>
                            <small class="text-muted">Section: {{ $child->section->name ?? 'N/A' }}</small>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="ri-user-line text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="ri-information-line me-2"></i>
            No children found. Please contact school administrator.
        </div>
    </div>
</div>
@endif

