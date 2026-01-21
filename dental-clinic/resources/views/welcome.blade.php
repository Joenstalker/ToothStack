<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUDAL-BLANCO DENTAL CLINIC - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-container {
            max-width: 1200px;
            width: 100%;
            padding: 2rem;
        }

        .welcome-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .header-section .subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .tooth-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .content-section {
            padding: 3rem 2rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            background: #f8fafc;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            color: #64748b;
            font-size: 0.9rem;
        }

        .cta-section {
            text-align: center;
            padding: 2rem 0;
        }

        .btn-custom {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-outline-custom {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .footer-section {
            background: #f8fafc;
            padding: 1.5rem;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 2rem;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .btn-custom {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-card">
            <!-- Header Section -->
            <div class="header-section">
                <div class="tooth-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <h1>CUDAL-BLANCO DENTAL CLINIC</h1>
                <p class="subtitle">Your Smile, Our Priority - Quality Dental Care You Can Trust</p>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="feature-title">Expert Dentists</div>
                        <div class="feature-desc">Experienced professionals dedicated to your oral health</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="feature-title">Easy Scheduling</div>
                        <div class="feature-desc">Book appointments online at your convenience</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-title">Safe & Hygienic</div>
                        <div class="feature-desc">State-of-the-art equipment and sterilization</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-smile-beam"></i>
                        </div>
                        <div class="feature-title">Comprehensive Care</div>
                        <div class="feature-desc">From checkups to cosmetic dentistry</div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="cta-section">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-custom btn-primary-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-custom btn-outline-custom">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Footer Section -->
            <div class="footer-section">
                <p>
                    <i class="fas fa-heart text-danger"></i>
                    CUDAL-BLANCO DENTAL CLINIC &copy; {{ date('Y') }}
                    <br>
                    <small>Powered by Laravel {{ Illuminate\Foundation\Application::VERSION }}</small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
