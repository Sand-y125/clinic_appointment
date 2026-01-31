<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Sandy Medical Clinic</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f9fafb;
            color: #1f2937;
        }

        header {
            background: white;
            padding: 1rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        header h2 {
            color: #2563eb;
            margin: 0;
        }

        nav a {
            margin-left: 1.5rem;
            text-decoration: none;
            color: #374151;
            font-weight: 500;
        }

        .about {
            max-width: 1000px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .about h1 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
        }

        .about p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 1.5rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-box {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .feature-box i {
            font-size: 2rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            background: white;
            margin-top: 4rem;
            color: #6b7280;
        }
    </style>
</head>

<body>

<header>
    <h2><i class="fas fa-clinic-medical"></i> Sandy Medical Clinic</h2>
    <nav>
        <a href="/clinic_appointment/public/index.php">Home</a>
        <a href="#">About Us</a>
        <a href="/clinic_appointment/public/appointment_book.php">Book Appointment</a>
    </nav>
</header>

<section class="about">
    <h1>About Sandy Medical Clinic</h1>

    <p>
        Sandy Medical Clinic is a trusted healthcare provider dedicated to delivering
        high-quality medical services with compassion and care. Our goal is to
        make healthcare accessible, efficient, and patient-friendly for everyone.
    </p>

    <p>
        With experienced doctors and modern facilities, we ensure that patients
        receive timely consultations and proper treatment. Our online appointment
        system allows you to book doctor visits easily, saving your valuable time.
    </p>

    <div class="features">
        <div class="feature-box">
            <i class="fas fa-user-md"></i>
            <h3>Expert Doctors</h3>
            <p>Highly qualified and experienced medical professionals.</p>
        </div>

        <div class="feature-box">
            <i class="fas fa-calendar-check"></i>
            <h3>Easy Appointments</h3>
            <p>Book appointments online anytime, anywhere.</p>
        </div>

        <div class="feature-box">
            <i class="fas fa-heartbeat"></i>
            <h3>Patient Care</h3>
            <p>Your health and comfort are always our priority.</p>
        </div>
    </div>
</section>

<footer>
    &copy; 2026 Sandy Medical Clinic. All rights reserved.
</footer>

</body>
</html>




