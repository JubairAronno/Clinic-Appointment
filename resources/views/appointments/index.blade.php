<!DOCTYPE html>
<html>
<head>
    <title>Clinic Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Clinic Appointment System</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> New Appointment
        </a>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Scheduled Appointments</h5>
            </div>
            <div class="card-body">
                @if($appointments->isEmpty())
                    <p class="text-center text-muted">No appointments scheduled yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Chamber</th>
                                    <th>Patient</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ date('M d, Y', strtotime($appointment->date)) }}</td>
                                    <td>{{ date('h:i A', strtotime($appointment->time)) }}</td>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->chamber_name }}</td>
                                    <td>{{ $appointment->patient_name ?? 'Not specified' }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $appointment->status == 'scheduled' ? 'warning' : 
                                            ($appointment->status == 'completed' ? 'success' : 'danger') 
                                        }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this appointment?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>