<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome to Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #4b3fdb;
            --secondary: #00cec9;
            --accent: #fd79a8;
            --light: #f8f9fa;
            --dark: #2d3436;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmZmZmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDVMNSAwWk02IDRMNCA2Wk0tMSAxTDEgLTFaIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiIHN0cm9rZS13aWR0aD0iMSI+PC9wYXRoPgo8L3N2Zz4=');
            opacity: 0.1;
            z-index: -1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .logo i {
            margin-right: 15px;
            color: var(--accent);
        }
        
        h1 {
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 3.5rem;
            line-height: 1.2;
            background: linear-gradient(to right, #fff, #c9d6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: none;
        }
        
        .tagline {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            max-width: 700px;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-color: transparent;
        }
        
        .btn:hover::before {
            opacity: 1;
        }
        
        .btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .illustration {
            width: 100%;
            max-width: 500px;
            margin: 3rem auto;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.3));
        }
        
        .floating-items {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-item {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-50px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            .tagline {
                font-size: 1rem;
            }
            
            .btn {
                padding: 0.8rem 1.8rem;
            }
            
            .btn-group {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="floating-items">
        <div class="floating-item" style="width: 100px; height: 100px; top: 10%; left: 5%;"></div>
        <div class="floating-item" style="width: 150px; height: 150px; top: 70%; left: 80%;"></div>
        <div class="floating-item" style="width: 60px; height: 60px; top: 20%; left: 85%;"></div>
        <div class="floating-item" style="width: 80px; height: 80px; top: 80%; left: 15%;"></div>
    </div>
    
    <div class="container">
        <div class="logo">
            <i class="fas fa-search-location"></i>
            Lost & Found Portal
        </div>
        
        <h1>Reuniting People With Their Belongings</h1>
        
        <p class="tagline">
            Our platform helps you find lost items or return found items to their rightful owners. 
            Join our community to make the world a little kinder, one found item at a time.
        </p>
        
        <div class="btn-group">
            <a href="register.php" class="btn">
                <i class="fas fa-user-plus"></i> Register
            </a>
            <a href="login.php" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
        
        <svg class="illustration" viewBox="0 0 500 300" xmlns="http://www.w3.org/2000/svg">
            <path d="M100,150 Q250,50 400,150 T100,150" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
            <circle cx="150" cy="120" r="20" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
            <circle cx="350" cy="180" r="15" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
            <path d="M250,100 L270,130 L230,130 Z" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
            <rect x="200" y="170" width="30" height="30" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="2" rx="5"/>
        </svg>
    </div>
    
    <script>
        // Simple animation for floating items
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.floating-item');
            items.forEach((item, index) => {
                // Randomize animation duration and delay
                const duration = 15 + Math.random() * 10;
                const delay = Math.random() * 5;
                item.style.animation = `float ${duration}s ${delay}s infinite ease-in-out`;
                
                // Randomize size and position a bit more
                const size = 50 + Math.random() * 100;
                item.style.width = `${size}px`;
                item.style.height = `${size}px`;
                item.style.top = `${Math.random() * 80 + 10}%`;
                item.style.left = `${Math.random() * 80 + 10}%`;
            });
        });
    </script>
</body>
</html>