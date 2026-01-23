document.addEventListener('DOMContentLoaded', function () {

    const doctor = document.getElementById('doctor_id');
    const date = document.getElementById('appointment_date');
    const time = document.getElementById('appointment_time');

    if (!doctor || !date || !time) return;

    doctor.addEventListener('change', loadTimes);
    date.addEventListener('change', loadTimes);

    function loadTimes() {
        if (!doctor.value || !date.value) {
            time.innerHTML = '<option value="">Select doctor and date first</option>';
            return;
        }

        fetch(`api.php?action=get_available_slots&doctor_id=${doctor.value}&date=${date.value}`)
            .then(res => res.json())
            .then(data => {
                time.innerHTML = '<option value="">Select time</option>';

                if (data.slots.length === 0) {
                    time.innerHTML = '<option value="">No slots available</option>';
                    return;
                }

                data.slots.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t;
                    opt.textContent = t;
                    time.appendChild(opt);
                });
            })
            .catch(() => {
                time.innerHTML = '<option value="">Error loading times</option>';
            });
    }
});
