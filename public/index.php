

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clinic Appointment System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: #f9fafb;
    color: #1f2937;
}

header {
    background: #ffffff;
    padding: 1.2rem 4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 100;
}

header h2 {
    color: #2563eb;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

nav a {
    margin-left: 2rem;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: color 0.3s ease;
}

nav a:hover {
    color: #2563eb;
}

.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 2.5rem 6rem;     
    gap: 3rem;
}

.hero-content {
    padding-top: 1rem;
}

.hero-content h1 {
    font-size: 3.2rem;
    line-height: 1.2;
    color: #1e293b;
    margin-bottom: 1.2rem;
}

.hero-content p {
    font-size: 1.1rem;
    color: #475569;
    line-height: 1.7;
    margin-bottom: 2.2rem;
    max-width: 520px;
}

.hero-buttons {
    display: flex;
    gap: 1.2rem;
}

.hero-buttons a {
    padding: 0.9rem 1.8rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #2563eb;
    color: #ffffff;
    box-shadow: 0 8px 18px rgba(37,99,235,0.25);
}

.btn-primary:hover {
    background: #1e4ed8;
    transform: translateY(-2px);
}

.btn-outline {
    border: 2px solid #2563eb;
    color: #2563eb;
    background: transparent;
}

.btn-outline:hover {
    background: #2563eb;
    color: white;
}

.hero-image {
    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
    position: relative;
}

.hero-image::before {
    content: '';
    position: absolute;
    width: 85%;
    height: 85%;
    background: #eef4ff;
    border-radius: 30px;
    top: -20px;
    right: -10px;
    z-index: -1;
}

.hero-image img {
    width: 100%;
    max-width: 520px;
    height: auto;
    object-fit: cover;
    margin-top: -30px; 
    border-radius: 20px;
}

footer {
    text-align: center;
    padding: 2rem;
    color: #64748b;
    background: #ffffff;
    margin-top: 3rem;
    font-size: 0.9rem;
}

@media (max-width: 992px) {
    .hero {
        grid-template-columns: 1fr;
        padding: 3rem 2rem;
        text-align: center;
    }

    .hero-content p {
        margin-left: auto;
        margin-right: auto;
    }

    .hero-buttons {
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-image {
        justify-content: center;
    }

    .hero-image img {
        margin-top: 0;
    }

    header {
        padding: 1rem 2rem;
    }
}
    </style>

</head>
<body>

<header>
    <h2><i class="fas fa-clinic-medical"></i>Sandy Medical Clinic</h2>
    <nav>
        <a href="#">Home</a>
        <a href="/clinic_appointment_dup/public/about.php">About us</a>
        <a href="/clinic_appointment_dup/public/appointment_book.php">Book Appointment</a>

    </nav>

    
</header>

<section class="hero">
    <div class="hero-content">
        <h1>Your Health,<br>Our Responsibility</h1>

        <p>
            Book your clinic appointment easily and quickly.
            Our doctors are ready to serve you with care and professionalism.
        </p>

        <div class="hero-buttons">
            <a href="/clinic_appointment/public/appointment_book.php" class="btn-primary">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </a>

            <a href="#" class="btn-outline">
                <i class="fas fa-stethoscope"></i> Our Services
            </a>
        </div>
    </div>

    <!-- IMAGE COLUMN (separate) -->
    <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d"
             alt="Doctor">
    </div>
</section>


<footer>
    © <?= date('Y') ?> Sandy Medical Clinic. All rights reserved.
</footer>

</body>
</html>
