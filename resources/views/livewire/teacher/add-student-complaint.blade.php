<div>
    <form wire:submit="store">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="classId" class="form-label">Class <span class="text-danger">*</span></label>
                <select wire:model.live="classId" id="classId" class="form-select @error('classId') is-invalid @enderror" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('classId')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="sectionId" class="form-label">Section</label>
                <select wire:model.live="sectionId" id="sectionId" class="form-select @error('sectionId') is-invalid @enderror" {{ !$classId ? 'disabled' : '' }}>
                    <option value="">All Sections</option>
                    @foreach($sections as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('sectionId')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="studentId" class="form-label">Student <span class="text-danger">*</span></label>
                <select wire:model="studentId" id="studentId" class="form-select @error('studentId') is-invalid @enderror" required {{ !$classId ? 'disabled' : '' }}>
                    <option value="">Select Student</option>
                    @foreach($students as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('studentId')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
                @if(!$classId)
                    <small class="text-muted d-block">Please select a class first</small>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                <input type="text" wire:model="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter complaint subject" required>
                @error('subject')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                <textarea wire:model="message" id="message" rows="6" class="form-control @error('message') is-invalid @enderror" placeholder="Enter complaint details" required></textarea>
                @error('message')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="store">
                    <i class="ri-save-line align-middle me-1"></i> Submit Complaint
                </span>
                <span wire:loading wire:target="store">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Submitting...
                </span>
            </button>
            <button type="button" wire:click="$reset" class="btn btn-secondary" wire:loading.attr="disabled">
                Reset
            </button>
        </div>
    </form>
</div>
