<!DOCTYPE html>
<html>
<head>
    <title>New Appointment - Clinic System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create New Appointment</h1>
        
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">Appointment Date</label>
                        <input type="date" class="form-control" id="date" name="date" required 
                               min="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required 
                               min="09:00" max="17:00" step="900">
                    </div>
                    
                    <div class="mb-3">
                        <label for="doctor_name" class="form-label">Doctor Name</label>
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="chamber_name" class="form-label">Chamber Name</label>
                        <input type="text" class="form-control" id="chamber_name" name="chamber_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Patient Name (Optional)</label>
                        <input type="text" class="form-control" id="patient_name" name="patient_name">
                    </div>
                    
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">Patient Phone (Optional)</label>
                        <input type="tel" class="form-control" id="patient_phone" name="patient_phone">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Notes (Optional)</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>