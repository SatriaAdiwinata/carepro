<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePro - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f5ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
            }
        }
        .left-side {
            width: 100%;
            background-color: #4f46e5;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        @media (min-width: 768px) {
            .left-side {
                width: 50%;
            }
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }
        .logo-icon {
            height: 40px;
            width: 40px;
            color: white;
        }
        .logo-text {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-left: 8px;
        }
        .hero-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .hero-description {
            color: #e0e7ff;
            margin-bottom: 24px;
        }
        .feature-list {
            margin-top: 24px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }
        .feature-icon-container {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            padding: 8px;
            margin-right: 12px;
        }
        .feature-icon {
            height: 20px;
            width: 20px;
            color: white;
        }
        .feature-text {
            color: white;
        }
        .footer-text {
            color: #e0e7ff;
            font-size: 14px;
            margin-top: 32px;
        }
        .right-side {
            width: 100%;
            padding: 32px;
        }
        @media (min-width: 768px) {
            .right-side {
                width: 50%;
            }
        }
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }
       .tab {
    width: 50%;
    padding: 12px 0;
    text-align: center;
    font-weight: 500;
    cursor: pointer;
    background: none;
    border: none;
    outline: none;
    color: #6b7280;
    text-decoration: none; /* HILANGKAN GARIS BAWAH */
}
        .tab-active {
            color: #4f46e5;
            border-bottom: 3px solid #4f46e5;
        }
        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .form-subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 0px;
        }
        .form-column {
            flex: 1;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 4px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        .form-help {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        .form-checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        .form-checkbox {
            height: 16px;
            width: 16px;
            accent-color: #4f46e5;
        }
        .form-checkbox-label {
            margin-left: 8px;
            font-size: 14px;
            color: #374151;
        }
        .form-link {
            color: #4f46e5;
            text-decoration: none;
        }
        .form-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }
        .forgot-password {
            font-size: 14px;
            text-align: right;
            margin-bottom: 4px;
        }
        .btn {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-primary {
            background-color: #4f46e5;
            color: white;
        }
        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }
        .divider-line {
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }
        .divider-text {
            padding: 0 12px;
            font-size: 14px;
            color: #6b7280;
            background-color: white;
        }
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            color: #000;
        }
        .btn-social:hover {
            background-color: #f9fafb;
        }
        .social-icon {
            height: 20px;
            width: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div>
                <div class="logo-container">
                    <img src="{{ asset('images/logologin.png') }}" alt="CarePro Logo" class="logo-icon">
                    <h1 class="logo-text">CarePro</h1>

                </div>
                <h2 class="hero-title">Find Your Dream Job Today</h2>
                <p class="hero-description">Connect with thousands of employers and discover opportunities that match your skills and aspirations.</p>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon-container">
                            <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="feature-text">Access to 10,000+ job listings</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon-container">
                            <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="feature-text">Resume builder and career tools</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon-container">
                            <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="feature-text">Personalized job recommendations</span>
                    </div>
                </div>
            </div>
            
            <div>
                <p class="footer-text">&copy; 2025 CarePro. All rights reserved.</p>
            </div>
        </div>
        
        <div class="right-side">
            @yield('content')
        </div>
    </div>
</body>
</html>