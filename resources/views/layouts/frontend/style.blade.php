    <style>
        @import url('https://rsms.me/inter/inter.css');


        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
            border-bottom-left-radius: 15px;
            /* Rounded corners for navbar */
            border-bottom-right-radius: 15px;
        }

        .navbar-brand img {
            height: 40px;
            border-radius: 8px;
            /* Rounded corners for logo */
        }

        .nav-link {
            color: #495057 !important;
            font-weight: 500;
            transition: color 0.3s ease;
            border-radius: 8px;
            /* Rounded corners for nav links */
        }

        .nav-link:hover {
            color: #007bff !important;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 50px;
            /* Pill-shaped buttons */
            padding: 10px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-outline-primary {
            border-color: #ffffff;
            color: #ffffff;
            border-radius: 50px;
            /* Pill-shaped buttons */
            padding: 10px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .hero-section {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
            padding: 100px 0;
            text-align: center;
            border-bottom-left-radius: 30px;
            /* More rounded corners for hero */
            border-bottom-right-radius: 30px;
            margin-bottom: 40px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-weight: 700;
            color: #007bff;
        }

        .card {
            border: none;
            border-radius: 15px;
            /* Rounded corners for cards */
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, .15);
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            font-weight: 600;
            color: #007bff;
        }

        .service-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        .portfolio-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            /* Rounded corners for portfolio items */
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .portfolio-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .portfolio-item:hover img {
            transform: scale(1.05);
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 15px;
            /* Rounded corners for overlay */
        }

        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }

        .portfolio-overlay h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .testimonial-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .testimonial-card .quote {
            font-style: italic;
            margin-bottom: 15px;
            color: #555;
        }

        .testimonial-card .author {
            font-weight: 600;
            color: #007bff;
        }

        .contact-section {
            background-color: #ffffff;
            padding: 60px 0;
            border-radius: 20px;
            /* More rounded corners for contact section */
            box-shadow: 0 4px 8px rgba(0, 0, 0, .05);
            margin-top: 40px;
        }

        .form-control {
            border-radius: 10px;
            /* Rounded corners for form inputs */
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
            margin-top: 50px;
            border-top-left-radius: 20px;
            /* Rounded corners for footer */
            border-top-right-radius: 20px;
        }

        footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #007bff;
        }

        .social-icons a {
            font-size: 1.5rem;
            margin: 0 10px;
            color: white;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #007bff;
        }
    </style>
    @stack('styles')
