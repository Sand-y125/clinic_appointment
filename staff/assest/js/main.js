
    const doctor = document.getElementById('doctor_id');
    const date = document.getElementById('appointment_date');
    const time = document.getElementById('appointment_time');

    if (!doctor || !date || !time) return;

    time.disabled = true;

    function toggleTime() {
        if (doctor.value && date.value) {
            time.disabled = false;
        } 
        else {
            time.disabled = true;
            time.selectedIndex = 0;
        }
    }

    doctor.addEventListener('change', toggleTime);
    date.addEventListener('change', toggleTime);

