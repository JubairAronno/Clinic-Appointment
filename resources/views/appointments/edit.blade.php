<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment - Clinic System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Appointment</h1>
        
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">Appointment Date</label>
                        <input type="date" class="form-control" id="date" name="date" 
                               value="{{ old('date', $appointment->date->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" 
                               value="{{ old('time', date('H:i', strtotime($appointment->time))) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="doctor_name" class="form-label">Doctor Name</label>
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" 
                               value="{{ old('doctor_name', $appointment->doctor_name) }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="chamber_name" class="form-label">Chamber Name</label>
                        <input type="text" class="form-control" id="chamber_name" name="chamber_name" 
                               value="{{ old('chamber_name', $appointment->chamber_name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patient_name" name="patient_name" 
                               value="{{ old('patient_name', $appointment->patient_name) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">Patient Phone</label>
                        <input type="tel" class="form-control" id="patient_phone" name="patient_phone" 
                               value="{{ old('patient_phone', $appointment->patient_phone) }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>