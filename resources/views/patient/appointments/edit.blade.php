@extends('layouts.patient')

@section('title', 'Edit Appointment')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Appointment</h1>
        <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Appointments
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Appointment Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.appointments.update', $appointment->id) }}" method="POST" id="editAppointmentForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="doctor_id" class="form-label">Select Doctor *</label>
                                <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                        id="doctor_id" name="doctor_id" required>
                                    <option value="">Choose a Doctor</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" 
                                        {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        @if(isset($doctor->user))
                                            Dr. {{ $doctor->user->first_name ?? '' }} {{ $doctor->user->last_name ?? '' }} - {{ $doctor->specialization ?? 'General' }}
                                        @elseif(isset($doctor->name))
                                            Dr. {{ $doctor->name }} - {{ $doctor->specialization ?? 'General' }}
                                        @else
                                            Doctor ID: {{ $doctor->id }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="appointment_date" class="form-label">Appointment Date *</label>
                                <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                       id="appointment_date" name="appointment_date" 
                                       value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="appointment_time" class="form-label">Appointment Time *</label>
                                <select class="form-select @error('appointment_time') is-invalid @enderror" 
                                       name="appointment_time" id="appointment_time" required>
                                    <option value="">Select Time</option>
                                    @php
                                        $timeSlots = [
                                            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                                            '12:00', '12:30', '14:00', '14:30', '15:00', '15:30',
                                            '16:00', '16:30', '17:00'
                                        ];
                                        $currentTime = old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'));
                                    @endphp
                                    @foreach($timeSlots as $time)
                                        <option value="{{ $time }}" {{ $currentTime == $time ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fixed Appointment Type Field -->
                            <div class="col-md-6">
                                <label for="appointment_type" class="form-label">Appointment Type *</label>
                                <select class="form-select @error('appointment_type') is-invalid @enderror" 
                                        name="appointment_type" id="appointment_type" required>
                                    <option value="">Select Type</option>
                                    <option value="consultation" {{ old('appointment_type', $appointment->appointment_type) == 'consultation' ? 'selected' : '' }}>
                                        Consultation
                                    </option>
                                    <option value="checkup" {{ old('appointment_type', $appointment->appointment_type) == 'checkup' ? 'selected' : '' }}>
                                        Checkup
                                    </option>
                                    <option value="followup" {{ old('appointment_type', $appointment->appointment_type) == 'followup' ? 'selected' : '' }}>
                                        Follow-up
                                    </option>
                                    <option value="emergency" {{ old('appointment_type', $appointment->appointment_type) == 'emergency' ? 'selected' : '' }}>
                                        Emergency
                                    </option>
                                    <option value="routine" {{ old('appointment_type', $appointment->appointment_type) == 'routine' ? 'selected' : '' }}>
                                        Routine Checkup
                                    </option>
                                    <option value="specialist" {{ old('appointment_type', $appointment->appointment_type) == 'specialist' ? 'selected' : '' }}>
                                        Specialist Visit
                                    </option>
                                </select>
                                @error('appointment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="reason" class="form-label">Reason for Appointment *</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" 
                                          id="reason" name="reason" rows="4" 
                                          placeholder="Please describe your symptoms or reason for the appointment..." 
                                          required>{{ old('reason', $appointment->reason) }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Any additional information you'd like to share...">{{ old('notes', $appointment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" id="updateBtn">
                                <i class="fas fa-save me-1"></i>Update Appointment
                            </button>
                            <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">Cancel</a>
                            
                            <!-- Delete Button - Only show for scheduled appointments -->
                            @if($appointment->status == 'scheduled')
                            <button type="button" class="btn btn-danger float-end" 
                                    data-bs-toggle="modal" data-bs-target="#deleteAppointmentModal">
                                <i class="fas fa-trash me-1"></i>Delete Appointment
                            </button>
                            @else
                            <button type="button" class="btn btn-danger float-end" disabled
                                    title="Cannot delete {{ $appointment->status }} appointments">
                                <i class="fas fa-trash me-1"></i>Delete Appointment
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Appointment Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Current Appointment</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <small class="text-muted">Appointment ID</small>
                            <div class="fw-bold">{{ $appointment->appointment_id ?? 'N/A' }}</div>
                        </div>
                        <div class="list-group-item px-0">
                            <small class="text-muted">Current Type</small>
                            <div class="fw-bold text-capitalize">{{ str_replace('-', ' ', $appointment->appointment_type) }}</div>
                        </div>
                        <div class="list-group-item px-0">
                            <small class="text-muted">Doctor</small>
                            <div>
                                @if(isset($appointment->doctor->user))
                                    Dr. {{ $appointment->doctor->user->first_name ?? '' }} {{ $appointment->doctor->user->last_name ?? '' }}
                                @elseif(isset($appointment->doctor->name))
                                    Dr. {{ $appointment->doctor->name }}
                                @else
                                    Doctor Not Found
                                @endif
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <small class="text-muted">Date & Time</small>
                            <div>{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                        </div>
                        <div class="list-group-item px-0">
                            <small class="text-muted">Status</small>
                            <div>
                                @php
                                    $statusColors = [
                                        'scheduled' => 'warning',
                                        'confirmed' => 'primary',
                                        'in-progress' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                        @if($appointment->fee)
                        <div class="list-group-item px-0">
                            <small class="text-muted">Fee</small>
                            <div class="text-success fw-bold">₹{{ number_format($appointment->fee, 2) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Important Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <small>
                            <strong>Please Note:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Appointments can only be edited if status is "Scheduled"</li>
                                <li>Emergency appointments have different time restrictions</li>
                                <li>Changes are subject to doctor's availability</li>
                                <li>You will receive a confirmation email after update</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if($appointment->status == 'scheduled')
<div class="modal fade" id="deleteAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this appointment?</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action cannot be undone. All appointment data will be permanently deleted.
                </div>
                <div class="card bg-light">
                    <div class="card-body">
                        <strong>Appointment Details:</strong><br>
                        Doctor: 
                        @if(isset($appointment->doctor->user))
                            Dr. {{ $appointment->doctor->user->first_name ?? '' }} {{ $appointment->doctor->user->last_name ?? '' }}
                        @elseif(isset($appointment->doctor->name))
                            Dr. {{ $appointment->doctor->name }}
                        @else
                            Doctor Not Found
                        @endif
                        <br>
                        Date: {{ $appointment->appointment_date->format('M d, Y') }}<br>
                        Time: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}<br>
                        Type: {{ ucfirst($appointment->appointment_type) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .list-group-item {
        border: none;
        padding: 0.5rem 0;
    }
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editAppointmentForm');
        const appointmentTypeSelect = document.getElementById('appointment_type');
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('appointment_time');
        const updateBtn = document.getElementById('updateBtn');

        // Set minimum date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.min = tomorrow.toISOString().split('T')[0];

        // Set maximum date to 3 months from now
        const maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 3);
        dateInput.max = maxDate.toISOString().split('T')[0];

        // Appointment type specific validations
        appointmentTypeSelect.addEventListener('change', function() {
            const appointmentType = this.value;
            
            if (appointmentType === 'emergency') {
                // Allow same-day booking for emergencies
                const today = new Date().toISOString().split('T')[0];
                dateInput.min = today;
                
                // Show emergency time slots
                updateTimeSlots(true);
            } else {
                // Regular appointments require at least 24 hours notice
                dateInput.min = tomorrow.toISOString().split('T')[0];
                
                // Show regular time slots
                updateTimeSlots(false);
            }
        });

        // Disable weekends for non-emergency appointments
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();
            const appointmentType = appointmentTypeSelect.value;
            
            // Allow weekends only for emergency appointments
            if ((dayOfWeek === 0 || dayOfWeek === 6) && appointmentType !== 'emergency') {
                alert('Please select a weekday (Monday to Friday) for non-emergency appointments');
                this.value = '';
                return;
            }
            
            // Update available time slots based on selected date
            updateTimeSlots(appointmentType === 'emergency');
        });

        // Function to update time slots
        function updateTimeSlots(isEmergency) {
            const currentTime = timeSelect.value;
            timeSelect.innerHTML = '<option value="">Select Time</option>';
            
            let timeSlots;
            
            if (isEmergency) {
                // Emergency time slots (extended hours)
                timeSlots = [
                    '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
                    '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'
                ];
            } else {
                // Regular time slots (business hours)
                timeSlots = [
                    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                    '12:00', '12:30', '14:00', '14:30', '15:00', '15:30',
                    '16:00', '16:30', '17:00'
                ];
            }
            
            timeSlots.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = new Date('2000-01-01T' + time).toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit', 
                    hour12: true 
                });
                
                if (time === currentTime) {
                    option.selected = true;
                }
                
                timeSelect.appendChild(option);
            });
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            const appointmentDate = dateInput.value;
            const appointmentTime = timeSelect.value;
            const doctorId = document.getElementById('doctor_id').value;
            const appointmentType = appointmentTypeSelect.value;
            const reason = document.getElementById('reason').value;
            
            // Basic validation
            if (!appointmentDate || !appointmentTime || !doctorId || !appointmentType || !reason.trim()) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }

            const selectedDateTime = new Date(appointmentDate + 'T' + appointmentTime);
            const now = new Date();
            
            // Allow same-day for emergencies, otherwise require future date
            if (appointmentType !== 'emergency' && selectedDateTime <= now) {
                e.preventDefault();
                alert('Please select a future date and time for your appointment.');
                return false;
            }

            // Emergency appointments can be same-day but not in the past
            if (appointmentType === 'emergency' && selectedDateTime < now) {
                e.preventDefault();
                alert('Please select a current or future time for emergency appointments.');
                return false;
            }

            // Show loading state
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
            updateBtn.disabled = true;
            
            return true;
        });

        // Initialize time slots based on current appointment type
        const currentAppointmentType = appointmentTypeSelect.value;
        updateTimeSlots(currentAppointmentType === 'emergency');
    });
</script>
@endsection