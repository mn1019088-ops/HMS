@extends('layouts.doctor')

@section('title', 'My Appointments')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2">My Appointments</h1>
        <div class="btn-group">
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-primary">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </div>
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Today's Appointments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('appointment_date', \Carbon\Carbon::today())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Scheduled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'scheduled')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Confirmed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'confirmed')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                In Progress</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'in-progress')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Cancelled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->where('status', 'cancelled')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointments->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Search & Filter
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter"></i> Toggle Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body">
                <form action="{{ route('doctor.appointments') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Search by patient name, ID, or reason..." 
                                       value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('doctor.appointments') }}" class="btn btn-secondary">Clear Filters</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="card border-light shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>All Appointments
                <span class="badge bg-light text-primary ms-2">{{ $appointments->total() }}</span>
            </h5>
            <div class="d-flex align-items-center">
                <span class="text-light me-3">Showing {{ $appointments->firstItem() ?? 0 }}-{{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() }}</span>
            </div>
        </div>

        <div class="card-body">
            @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Appointment ID</th>
                            <th>Patient</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Reason</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                                <td>
                                    <strong>{{ $appointment->appointment_id }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            @if($appointment->patient->profile_image)
                                                <img src="{{ asset('storage/' . $appointment->patient->profile_image) }}" 
                                                     alt="{{ $appointment->patient->first_name }}" 
                                                     class="rounded-circle avatar-sm">
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">
                                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                            </h6>
                                            <small class="text-muted">
                                                ID: {{ $appointment->patient->patient_id }} | 
                                                Age: {{ $appointment->patient->date_of_birth ? \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age . 'y' : 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark text-uppercase">
                                        {{ $appointment->appointment_type }}
                                    </span>
                                </td>
                                <td>
                                    <span data-bs-toggle="tooltip" title="{{ $appointment->reason }}">
                                        {{ \Illuminate\Support\Str::limit($appointment->reason, 30) }}
                                    </span>
                                </td>
                                <td>
                                    @if($appointment->fee)
                                        <span class="text-success fw-bold">
                                            ₹{{ number_format($appointment->fee, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'scheduled' => 'warning',
                                            'confirmed' => 'primary',
                                            'in-progress' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'scheduled' => 'clock',
                                            'confirmed' => 'check-circle',
                                            'in-progress' => 'spinner',
                                            'completed' => 'check',
                                            'cancelled' => 'times-circle'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                        <i class="fas fa-{{ $statusIcons[$appointment->status] ?? 'circle' }} me-1"></i>
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Start Appointment Button -->
                                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                                            <form action="{{ route('doctor.appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in-progress">
                                                <button type="submit" class="btn btn-sm btn-info" 
                                                        title="Start Appointment"
                                                        onclick="return confirm('Start appointment with {{ $appointment->patient->first_name }}?')">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Complete Appointment Button -->
                                        @if($appointment->status === 'in-progress')
                                            <form action="{{ route('doctor.appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        title="Complete Appointment"
                                                        onclick="return confirm('Mark appointment as completed?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- View Details Button -->
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewAppointmentModal{{ $appointment->id }}" 
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Edit Button - Opens Edit Modal -->
                                        @if(in_array($appointment->status, ['scheduled', 'confirmed', 'in-progress']))
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editAppointmentModal{{ $appointment->id }}" 
                                                    title="Edit Appointment">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-warning" disabled title="Cannot edit completed or cancelled appointments">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif

                                        <!-- Cancel Button -->
                                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                                            <form action="{{ route('doctor.appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Cancel Appointment"
                                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- View Appointment Modal -->
                            <div class="modal fade" id="viewAppointmentModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="viewAppointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-light shadow-sm">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="viewAppointmentModalLabel{{ $appointment->id }}">
                                                <i class="fas fa-calendar-alt me-2"></i>Appointment Details
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="fas fa-user me-2"></i>Patient Information
                                                    </h6>
                                                    <div class="mb-3">
                                                        <strong>Name:</strong><br>
                                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Patient ID:</strong><br>
                                                        {{ $appointment->patient->patient_id }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Age & Gender:</strong><br>
                                                        {{ $appointment->patient->date_of_birth ? \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age . ' years' : 'N/A' }}, 
                                                        {{ ucfirst($appointment->patient->gender) }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Phone:</strong><br>
                                                        {{ $appointment->patient->phone ?? 'N/A' }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Email:</strong><br>
                                                        {{ $appointment->patient->email ?? 'N/A' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="fas fa-calendar me-2"></i>Appointment Details
                                                    </h6>
                                                    <div class="mb-3">
                                                        <strong>Appointment ID:</strong><br>
                                                        {{ $appointment->appointment_id }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Date:</strong><br>
                                                        {{ $appointment->appointment_date->format('F d, Y') }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Time:</strong><br>
                                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Type:</strong><br>
                                                        <span class="badge bg-info text-dark text-uppercase">
                                                            {{ $appointment->appointment_type }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Status:</strong><br>
                                                        <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                                            <i class="fas fa-{{ $statusIcons[$appointment->status] ?? 'circle' }} me-1"></i>
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </div>
                                                    @if($appointment->fee)
                                                    <div class="mb-3">
                                                        <strong>Fee:</strong><br>
                                                        <span class="text-success fw-bold fs-5">
                                                            ₹{{ number_format($appointment->fee, 2) }}
                                                        </span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="fas fa-stethoscope me-2"></i>Medical Information
                                                    </h6>
                                                    <div class="mb-3">
                                                        <strong>Reason for Visit:</strong><br>
                                                        {{ $appointment->reason }}
                                                    </div>
                                                    @if($appointment->notes)
                                                    <div class="mb-3">
                                                        <strong>Additional Notes:</strong><br>
                                                        {{ $appointment->notes }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Close
                                            </button>
                                            @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                                            <form action="{{ route('doctor.appointments.update-status', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in-progress">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="fas fa-play me-1"></i>Start
                                                </button>
                                            </form>
                                            @endif
                                            @if(in_array($appointment->status, ['scheduled', 'confirmed', 'in-progress']))
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editAppointmentModal{{ $appointment->id }}" 
                                                    data-bs-dismiss="modal">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Appointment Modal -->
                            <div class="modal fade" id="editAppointmentModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="editAppointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-light shadow-sm">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title" id="editAppointmentModalLabel{{ $appointment->id }}">
                                                <i class="fas fa-edit me-2"></i>Edit Appointment
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-warning mb-3">
                                                            <i class="fas fa-user me-2"></i>Patient Information
                                                        </h6>
                                                        <div class="mb-3">
                                                            <strong>Patient:</strong><br>
                                                            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                            (ID: {{ $appointment->patient->patient_id }})
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-warning mb-3">
                                                            <i class="fas fa-calendar me-2"></i>Appointment Details
                                                        </h6>
                                                        <div class="mb-3">
                                                            <strong>Appointment ID:</strong><br>
                                                            {{ $appointment->appointment_id }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Current Doctor:</strong><br>
                                                            {{ $appointment->doctor->user->first_name ?? auth()->user()->first_name }} {{ $appointment->doctor->user->last_name ?? auth()->user()->last_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                
                                                <!-- Hidden Doctor ID Field - Fixed -->
                                                @php
                                                    $currentDoctorId = $appointment->doctor_id ?? auth()->id();
                                                @endphp
                                                <input type="hidden" name="doctor_id" value="{{ $currentDoctorId }}">
                                                
                                                <!-- Editable Fields -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="appointment_date{{ $appointment->id }}" class="form-label">
                                                                <strong>Appointment Date *</strong>
                                                            </label>
                                                            <input type="date" 
                                                                   class="form-control @error('appointment_date') is-invalid @enderror" 
                                                                   id="appointment_date{{ $appointment->id }}" 
                                                                   name="appointment_date" 
                                                                   value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                                                                   required
                                                                   min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                                            @error('appointment_date')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="appointment_time{{ $appointment->id }}" class="form-label">
                                                                <strong>Appointment Time *</strong>
                                                            </label>
                                                            <input type="time" 
                                                                   class="form-control @error('appointment_time') is-invalid @enderror" 
                                                                   id="appointment_time{{ $appointment->id }}" 
                                                                   name="appointment_time" 
                                                                   value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}"
                                                                   required>
                                                            @error('appointment_time')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="appointment_type{{ $appointment->id }}" class="form-label">
                                                                <strong>Appointment Type *</strong>
                                                            </label>
                                                            <select class="form-select @error('appointment_type') is-invalid @enderror" 
                                                                    id="appointment_type{{ $appointment->id }}" 
                                                                    name="appointment_type" required>
                                                                <option value="">Select Type</option>
                                                                <option value="consultation" {{ old('appointment_type', $appointment->appointment_type) == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                                                <option value="checkup" {{ old('appointment_type', $appointment->appointment_type) == 'checkup' ? 'selected' : '' }}>Checkup</option>
                                                                <option value="followup" {{ old('appointment_type', $appointment->appointment_type) == 'followup' ? 'selected' : '' }}>Follow-up</option>
                                                                <option value="emergency" {{ old('appointment_type', $appointment->appointment_type) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                                                <option value="surgery" {{ old('appointment_type', $appointment->appointment_type) == 'surgery' ? 'selected' : '' }}>Surgery</option>
                                                                <option value="therapy" {{ old('appointment_type', $appointment->appointment_type) == 'therapy' ? 'selected' : '' }}>Therapy</option>
                                                            </select>
                                                            @error('appointment_type')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="status{{ $appointment->id }}" class="form-label">
                                                                <strong>Status *</strong>
                                                            </label>
                                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                                    id="status{{ $appointment->id }}" 
                                                                    name="status" required>
                                                                <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                                <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                                <option value="in-progress" {{ old('status', $appointment->status) == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                            </select>
                                                            @error('status')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="fee{{ $appointment->id }}" class="form-label">
                                                                <strong>Fee (₹) *</strong>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light">₹</span>
                                                                <input type="number" 
                                                                       class="form-control @error('fee') is-invalid @enderror" 
                                                                       id="fee{{ $appointment->id }}" 
                                                                       name="fee" 
                                                                       value="{{ old('fee', $appointment->fee) }}"
                                                                       step="0.01"
                                                                       min="0"
                                                                       placeholder="0.00"
                                                                       required>
                                                                @error('fee')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <small class="text-muted">Enter fee in Indian Rupees</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label d-block">&nbsp;</label>
                                                            <div class="card bg-light">
                                                                <div class="card-body py-2">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        <strong>Suggested Fees:</strong><br>
                                                                        Consultation: ₹500-₹1000<br>
                                                                        Checkup: ₹300-₹700<br>
                                                                        Follow-up: ₹200-₹500<br>
                                                                        Emergency: ₹1000-₹5000
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="reason{{ $appointment->id }}" class="form-label">
                                                                <strong>Reason for Visit *</strong>
                                                            </label>
                                                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                                                      id="reason{{ $appointment->id }}" 
                                                                      name="reason" 
                                                                      rows="3" 
                                                                      required
                                                                      placeholder="Describe the reason for the appointment...">{{ old('reason', $appointment->reason) }}</textarea>
                                                            @error('reason')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="notes{{ $appointment->id }}" class="form-label">
                                                                <strong>Additional Notes</strong>
                                                            </label>
                                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                                      id="notes{{ $appointment->id }}" 
                                                                      name="notes" 
                                                                      rows="3" 
                                                                      placeholder="Any additional notes or comments...">{{ old('notes', $appointment->notes) }}</textarea>
                                                            @error('notes')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-save me-1"></i>Update Appointment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} entries
                </div>
                <div>
                    {{ $appointments->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Appointments Found</h4>
                <p class="text-muted">No appointments match your search criteria.</p>
                <a href="{{ route('doctor.appointments') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-1"></i>Clear Filters
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .border-left-secondary {
        border-left: 0.25rem solid #858796 !important;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    .modal-header.bg-warning {
        background: linear-gradient(45deg, #f6c23e, #f8d56c) !important;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-close alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Filter collapse persistence
        const filterCollapse = document.getElementById('filterCollapse');
        const urlParams = new URLSearchParams(window.location.search);
        
        // Show filters if any search parameters are present
        if (urlParams.toString()) {
            new bootstrap.Collapse(filterCollapse, { show: true });
        }

        // Date field - set max date to one year from now
        const dateField = document.getElementById('date');
        if (dateField) {
            const today = new Date();
            const oneYearLater = new Date(today.getFullYear() + 1, today.getMonth(), today.getDate());
            dateField.max = oneYearLater.toISOString().split('T')[0];
        }

        // Status change confirmation
        const statusForms = document.querySelectorAll('form[action*="update-status"]');
        statusForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const status = this.querySelector('input[name="status"]').value;
                const patientName = this.closest('tr').querySelector('h6').textContent.trim();
                
                let message = '';
                switch(status) {
                    case 'in-progress':
                        message = `Start appointment with ${patientName}?`;
                        break;
                    case 'completed':
                        message = `Mark appointment with ${patientName} as completed?`;
                        break;
                    case 'cancelled':
                        message = `Cancel appointment with ${patientName}? This action cannot be undone.`;
                        break;
                }
                
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });

        // Set minimum date for appointment date fields
        const appointmentDateFields = document.querySelectorAll('input[name="appointment_date"]');
        appointmentDateFields.forEach(field => {
            const today = new Date();
            field.min = today.toISOString().split('T')[0];
            
            // Set max date to one year from now
            const oneYearLater = new Date(today.getFullYear() + 1, today.getMonth(), today.getDate());
            field.max = oneYearLater.toISOString().split('T')[0];
        });

        // Fee field formatting
        const feeFields = document.querySelectorAll('input[name="fee"]');
        feeFields.forEach(field => {
            field.addEventListener('input', function(e) {
                // Ensure only numbers and decimal points
                this.value = this.value.replace(/[^0-9.]/g, '');
                
                // Ensure only one decimal point
                const decimalCount = (this.value.match(/\./g) || []).length;
                if (decimalCount > 1) {
                    this.value = this.value.slice(0, -1);
                }
                
                // Limit to 2 decimal places
                if (this.value.includes('.')) {
                    const parts = this.value.split('.');
                    if (parts[1].length > 2) {
                        this.value = parts[0] + '.' + parts[1].substring(0, 2);
                    }
                }
            });
        });

        // Check if there are any success/error messages and scroll to top
        @if(session('success') || session('error') || $errors->any())
            window.scrollTo({ top: 0, behavior: 'smooth' });
        @endif
    });
</script>
@endsection