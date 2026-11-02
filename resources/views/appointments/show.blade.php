<!DOCTYPE html>
<html>
<head>
    <title>View Appointment - Clinic System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Appointment Details</h1>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Appointment Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ date('M d, Y', strtotime($appointment->date)) }}</p>
                        <p><strong>Time:</strong> {{ date('h:i A', strtotime($appointment->time)) }}</p>
                        <p><strong>Doctor:</strong> {{ $appointment->doctor_name }}</p>
                        <p><strong>Chamber:</strong> {{ $appointment->chamber_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> {{ $appointment->patient_name ?? 'Not specified' }}</p>
                        <p><strong>Phone:</strong> {{ $appointment->patient_phone ?? 'Not specified' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ 
                                $appointment->status == 'scheduled' ? 'warning' : 
                                ($appointment->status == 'completed' ? 'success' : 'danger') 
                            }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </p>
                        <p><strong>Created:</strong> {{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                
                @if($appointment->notes)
                <div class="mt-3">
                    <strong>Notes:</strong>
                    <p class="border p-3 rounded">{{ $appointment->notes }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this appointment?')">Delete</button>
                </form>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html>