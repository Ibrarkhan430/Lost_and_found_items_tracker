<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOST & FOUND HUB | Reuniting Lives</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6C5CE7;
            --secondary: #4B3FDB;
            --accent: #FF7675;
            --gold: #FDCB6E;
            --dark: #2D3436;
            --light: #F5F6FA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--dark);
            overflow-x: hidden;
            position: relative;
        }
         /* Add logout button styles */
        .logout-btn {
            position: fixed;
            top: 20px;
            right: 30px;
            padding: 10px 22px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(255, 77, 77, 0.6);
            transition: background-color 0.3s ease;
            z-index: 1000;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1518655048521-f130df041f66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: -1;
        }

        .glass-container {
            width: 90%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: var(--light);
            transform: skewY(-3deg);
            z-index: 1;
        }

        .logo {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logo i {
            margin-right: 15px;
            color: var(--gold);
        }

        .tagline {
            font-size: 1.2rem;
            font-weight: 300;
            max-width: 700px;
            margin: 0 auto 1.5rem;
            opacity: 0.9;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 3rem 2rem;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .action-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .card-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .lost-card .card-icon {
            background: linear-gradient(135deg, var(--accent), #FF4757);
            -webkit-background-clip: text;
        }

        .admin-card .card-icon {
            background: linear-gradient(135deg, var(--dark), #636E72);
            -webkit-background-clip: text;
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .card-desc {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .card-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(108, 92, 231, 0.4);
            position: relative;
            overflow: hidden;
        }

        .card-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
        }

        .card-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .card-btn:hover::before {
            left: 100%;
        }

        .lost-card .card-btn {
            background: linear-gradient(135deg, var(--accent), #FF4757);
            box-shadow: 0 5px 20px rgba(255, 118, 117, 0.4);
        }

        .lost-card .card-btn:hover {
            box-shadow: 0 8px 25px rgba(255, 118, 117, 0.6);
        }

        .admin-card .card-btn {
            background: linear-gradient(135deg, var(--dark), #636E72);
            box-shadow: 0 5px 20px rgba(45, 52, 54, 0.4);
        }

        .admin-card .card-btn:hover {
            box-shadow: 0 8px 25px rgba(45, 52, 54, 0.6);
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
            opacity: 0.15;
            animation: float 8s infinite ease-in-out;
            font-size: 3rem;
            color: white;
        }

        .floating-item:nth-child(1) {
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-item:nth-child(2) {
            top: 70%;
            left: 80%;
            animation-delay: 1s;
        }

        .floating-item:nth-child(3) {
            top: 40%;
            left: 85%;
            animation-delay: 2s;
        }

        .floating-item:nth-child(4) {
            top: 80%;
            left: 15%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            background: rgba(0, 0, 0, 0.1);
        }

        .credits {
            font-weight: 600;
            color: var(--gold);
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2.2rem;
            }

            .tagline {
                font-size: 1rem;
            }

            .action-grid {
                grid-template-columns: 1fr;
                padding: 2rem 1rem;
            }

            .hero-section {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-items">
        <i class="floating-item fas fa-key"></i>
        <i class="floating-item fas fa-wallet"></i>
        <i class="floating-item fas fa-mobile-alt"></i>
        <i class="floating-item fas fa-camera"></i>
    </div>

    <div class="glass-container">
        <div class="hero-section">
            <div class="logo">
                <i class="fas fa-hands-helping"></i>
                <span>LOST & FOUND HUB</span>
            </div>
            <h1 style="font-size: 3.5rem; margin-bottom: 0.5rem;">Reuniting What Matters</h1>
            <p class="tagline">The most advanced platform to report and recover lost items with AI-powered matching</p>
        </div>
        <!-- for logout button-->
         <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

        <div class="action-grid">
            <div class="action-card">
                <i class="fas fa-hands-helping card-icon"></i>
                <h3 class="card-title">Found an Item?</h3>
                <p class="card-desc">Help return lost belongings to their owners. Your kindness makes our community stronger.</p>
                <a href="submit_item.php" class="card-btn">Report Found Item</a>
            </div>

            <div class="action-card lost-card">
                <i class="fas fa-search card-icon"></i>
                <h3 class="card-title">Lost an Item?</h3>
                <p class="card-desc">Create a detailed report. Our system will instantly notify you if a match is found.</p>
                <a href="form_uploading.php" class="card-btn">Report Lost Item</a>
            </div>

            <div class="action-card admin-card">
                <i class="fas fa-lock card-icon"></i>
                <h3 class="card-title">Admin Portal</h3>
                <p class="card-desc">Access the secure dashboard to manage reports and verify item matches.</p>
                <a href="admin_login.php" class="card-btn">Admin Login</a>
            </div>

            <div style="text-align:center; margin-top: 20px;">
    <a href="notifications.php">
        <button style="padding: 12px 25px; font-size: 16px; background-color: #2196F3; color: white; border: none; border-radius: 8px;">
            🔔 View Notifications
        </button>
    </a>
</div>
        </div>

        <div class="footer">
            <p>© 2025 LOST & FOUND HUB | Designed with by <span class="credits">Ibrar Ahmad & Muhammad Abbas</span></p>
        </div>
    </div>
</body>
</html>
