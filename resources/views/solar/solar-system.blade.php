<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar System Explorer | Ultra Realistic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #000;
            color: #fff;
            overflow-x: hidden;
            cursor: default;
        }

        /* Cosmic Background with Nebula */
        .cosmic-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -3;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 40% 80%, rgba(120, 219, 255, 0.2) 0%, transparent 50%),
                radial-gradient(circle at center, #0a0a2e 0%, #000000 100%);
            animation: nebulaPulse 20s ease-in-out infinite;
        }

        @keyframes nebulaPulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        /* Animated Stars */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .star {
            position: absolute;
            background: #fff;
            border-radius: 50%;
            animation: twinkle var(--duration) infinite ease-in-out;
            opacity: 0;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1); }
        }

        /* Shooting Stars */
        .shooting-star {
            position: absolute;
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #fff, transparent);
            border-radius: 50%;
            filter: blur(1px);
            animation: shoot linear forwards;
            z-index: -1;
        }

        @keyframes shoot {
            0% { transform: translateX(-100px) translateY(0) rotate(45deg); opacity: 0; }
            10% { opacity: 1; }
            100% { transform: translateX(100vw) translateY(100vh) rotate(45deg); opacity: 0; }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 25px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        nav.hidden {
            transform: translateY(-100%);
            opacity: 0;
        }

        .logo {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .nav-links {
            display: flex;
            gap: 35px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .nav-links a:hover::before {
            left: 100%;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        /* Sections */
        section {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(100px);
            transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        section.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Introduction Section */
        #intro {
            text-align: center;
            padding: 0 20px;
            background: radial-gradient(ellipse at center, rgba(26, 26, 46, 0.8) 0%, rgba(0,0,0,0) 70%);
        }

        .intro-content {
            max-width: 900px;
            z-index: 2;
        }

        h1 {
            font-size: 6rem;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #fff, #4facfe, #00f2fe, #a8ff78);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 6s ease infinite, glow 3s ease-in-out infinite alternate;
            text-shadow: 0 0 50px rgba(79, 172, 254, 0.5);
            font-weight: 900;
            letter-spacing: 2px;
        }

        @keyframes glow {
            from { text-shadow: 0 0 30px rgba(79, 172, 254, 0.5), 0 0 60px rgba(79, 172, 254, 0.3); }
            to { text-shadow: 0 0 40px rgba(0, 242, 254, 0.8), 0 0 80px rgba(0, 242, 254, 0.6), 0 0 100px rgba(0, 242, 254, 0.4); }
        }

        .intro-content p {
            font-size: 1.5rem;
            line-height: 1.8;
            margin-bottom: 50px;
            color: #e0e0e0;
            text-shadow: 0 2px 20px rgba(0,0,0,0.5);
            font-weight: 300;
        }

        .cta-button {
            display: inline-block;
            padding: 20px 50px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.3rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
            position: relative;
            overflow: hidden;
            animation: pulse 2s infinite, float 6s ease-in-out infinite;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.8s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.6);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite, fadeIn 1s ease 2s forwards;
            opacity: 0;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0) translateX(-50%); }
            40% { transform: translateY(-20px) translateX(-50%); }
            60% { transform: translateY(-10px) translateX(-50%); }
        }

        /* Planet Sections */
        .planet-section {
            padding: 100px 50px;
        }

        .planet-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: center;
        }

        .planet-info {
            padding: 50px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            transform: translateX(-100px);
            opacity: 0;
            transition: all 1s ease 0.3s;
            position: relative;
            overflow: hidden;
        }

        .planet-section.active .planet-info {
            transform: translateX(0);
            opacity: 1;
        }

        .planet-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, var(--planet-glow), transparent);
            opacity: 0.1;
            z-index: -1;
        }

        .planet-title {
            font-size: 4.5rem;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 3px;
            background: linear-gradient(45deg, #fff, var(--planet-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 5px 25px rgba(0,0,0,0.5);
            font-weight: 800;
        }

        .planet-description {
            font-size: 1.3rem;
            line-height: 1.8;
            margin-bottom: 35px;
            color: #e0e0e0;
            font-weight: 300;
        }

        .planet-facts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 35px;
        }

        .fact {
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid var(--planet-color);
            transition: all 0.4s ease;
            transform: translateY(20px);
            opacity: 0;
        }

        .planet-section.active .fact {
            transform: translateY(0);
            opacity: 1;
        }

        .planet-section.active .fact:nth-child(1) { transition-delay: 0.5s; }
        .planet-section.active .fact:nth-child(2) { transition-delay: 0.6s; }
        .planet-section.active .fact:nth-child(3) { transition-delay: 0.7s; }
        .planet-section.active .fact:nth-child(4) { transition-delay: 0.8s; }

        .fact:hover {
            transform: translateY(-8px) scale(1.02);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .fact i {
            margin-right: 12px;
            color: var(--planet-color);
            font-size: 1.4rem;
        }

        .planet-model {
            height: 600px;
            position: relative;
            transform: translateX(100px) scale(0.8);
            opacity: 0;
            transition: all 1s ease 0.6s;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 
                0 0 100px var(--planet-glow),
                0 0 200px var(--planet-glow),
                inset 0 0 50px rgba(255,255,255,0.1);
        }

        .planet-section.active .planet-model {
            transform: translateX(0) scale(1);
            opacity: 1;
        }

        /* Planet Specific Backgrounds */
        #mercury {
            --planet-color: #8C7853;
            --planet-glow: rgba(140, 120, 83, 0.5);
            background: 
                radial-gradient(ellipse at 30% 40%, rgba(140, 120, 83, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 60%, rgba(100, 80, 53, 0.2) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #1a140a 100%);
        }

        #venus {
            --planet-color: #E39E54;
            --planet-glow: rgba(227, 158, 84, 0.5);
            background: 
                radial-gradient(ellipse at 40% 30%, rgba(227, 158, 84, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 70%, rgba(200, 130, 60, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #2a1a0a 100%);
        }

        #earth {
            --planet-color: #6B93D6;
            --planet-glow: rgba(107, 147, 214, 0.5);
            background: 
                radial-gradient(ellipse at 50% 50%, rgba(107, 147, 214, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(86, 126, 194, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #0a1a2a 100%);
        }

        #mars {
            --planet-color: #CD5C5C;
            --planet-glow: rgba(205, 92, 92, 0.5);
            background: 
                radial-gradient(ellipse at 30% 70%, rgba(205, 92, 92, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 30%, rgba(180, 70, 70, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #2a0a0a 100%);
        }

        #jupiter {
            --planet-color: #C19E6B;
            --planet-glow: rgba(193, 158, 107, 0.5);
            background: 
                radial-gradient(ellipse at 50% 50%, rgba(193, 158, 107, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 20% 80%, rgba(170, 135, 85, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #2a1a0a 100%);
        }

        /* Floating Particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: var(--planet-color);
            border-radius: 50%;
            opacity: 0.6;
            animation: floatParticle linear infinite;
            filter: blur(1px);
        }

        @keyframes floatParticle {
            to { 
                transform: translateY(-100vh) rotate(360deg); 
                opacity: 0;
            }
        }

        /* Footer */
        footer {
            background: linear-gradient(180deg, #000 0%, #1a1a2e 100%);
            padding: 80px 20px 40px;
            text-align: center;
            position: relative;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 16px;
            border-radius: 20px;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #4facfe;
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: #4facfe;
            background: rgba(255,255,255,0.05);
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px 0;
        }

        .social-icons a {
            color: #fff;
            font-size: 2rem;
            transition: all 0.4s ease;
            display: inline-block;
            padding: 15px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .social-icons a:hover {
            color: #4facfe;
            transform: translateY(-8px) scale(1.2);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .copyright {
            margin-top: 50px;
            color: #777;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 968px) {
            .planet-container {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            
            h1 {
                font-size: 4rem;
            }
            
            .planet-title {
                font-size: 3.5rem;
            }
            
            .planet-model {
                height: 500px;
                order: -1;
            }
            
            .planet-info {
                padding: 40px 30px;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 20px;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .nav-links a {
                font-size: 14px;
                padding: 8px 16px;
            }
            
            h1 {
                font-size: 3rem;
            }
            
            .planet-facts {
                grid-template-columns: 1fr;
            }
            
            .planet-model {
                height: 400px;
            }
        }
    </style>
</head>
<body>
    <!-- Cosmic Background -->
    <div class="cosmic-bg"></div>
    <div class="stars" id="stars"></div>

    <!-- Navigation -->
    <nav id="navbar">
        <div class="logo">CosmicExplorer</div>
        <div class="nav-links">
            <a href="#intro">Home</a>
            <a href="#mercury">Mercury</a>
            <a href="#venus">Venus</a>
            <a href="#earth">Earth</a>
            <a href="#mars">Mars</a>
            <a href="#jupiter">Jupiter</a>
        </div>
    </nav>

    <!-- Introduction Section -->
    <section id="intro" class="active">
        <div class="intro-content">
            <h1>Journey Through the Cosmos</h1>
            <p>Embark on an epic adventure across our solar system. Discover breathtaking worlds with realistic 3D models, from fiery Mercury to the giant Jupiter. Each planet holds unique secrets waiting to be uncovered.</p>
            <a href="#mercury" class="cta-button">
                <i class="fas fa-rocket"></i> Launch Exploration
            </a>
        </div>
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down fa-2x"></i>
        </div>
    </section>

    <!-- Mercury Section -->
    <section id="mercury" class="planet-section">
        <div class="particles" id="mercury-particles"></div>
        <div class="planet-container">
            <div class="planet-info">
                <h2 class="planet-title">Mercury</h2>
                <p class="planet-description">The swift messenger of the gods, Mercury is the smallest and innermost planet in our solar system. With extreme temperature variations and a surface scarred by impacts, this world offers a dramatic contrast between its scorching days and freezing nights.</p>
                <div class="planet-facts">
                    <div class="fact"><i class="fas fa-thermometer-full"></i> Day: 430°C</div>
                    <div class="fact"><i class="fas fa-snowflake"></i> Night: -180°C</div>
                    <div class="fact"><i class="fas fa-expand-arrows-alt"></i> Diameter: 4,879 km</div>
                    <div class="fact"><i class="fas fa-bolt"></i> Orbital Period: 88 days</div>
                </div>
            </div>
            <div class="planet-model" id="mercury-model">
                <!-- 3D model will be rendered here -->
            </div>
        </div>
    </section>

    <!-- Venus Section -->
    <section id="venus" class="planet-section">
        <div class="particles" id="venus-particles"></div>
        <div class="planet-container">
            <div class="planet-info">
                <h2 class="planet-title">Venus</h2>
                <p class="planet-description">Shrouded in thick clouds of sulfuric acid, Venus is Earth's twisted sister. Despite being similar in size, its runaway greenhouse effect creates surface temperatures hot enough to melt lead, making it the hottest planet in our solar system.</p>
                <div class="planet-facts">
                    <div class="fact"><i class="fas fa-fire"></i> Temperature: 471°C</div>
                    <div class="fact"><i class="fas fa-cloud"></i> Atmosphere: CO₂</div>
                    <div class="fact"><i class="fas fa-expand-arrows-alt"></i> Diameter: 12,104 km</div>
                    <div class="fact"><i class="fas fa-sync-alt"></i> Day: 243 Earth days</div>
                </div>
            </div>
            <div class="planet-model" id="venus-model">
                <!-- 3D model will be rendered here -->
            </div>
        </div>
    </section>

    <!-- Earth Section -->
    <section id="earth" class="planet-section">
        <div class="particles" id="earth-particles"></div>
        <div class="planet-container">
            <div class="planet-info">
                <h2 class="planet-title">Earth</h2>
                <p class="planet-description">Our precious blue marble, the only known world to harbor life. From the vast oceans to the protective atmosphere, Earth is a complex system of interconnected processes that have nurtured life for billions of years.</p>
                <div class="planet-facts">
                    <div class="fact"><i class="fas fa-tint"></i> 71% Water Coverage</div>
                    <div class="fact"><i class="fas fa-leaf"></i> Life: Abundant</div>
                    <div class="fact"><i class="fas fa-expand-arrows-alt"></i> Diameter: 12,742 km</div>
                    <div class="fact"><i class="fas fa-moon"></i> 1 Natural Satellite</div>
                </div>
            </div>
            <div class="planet-model" id="earth-model">
                <!-- 3D model will be rendered here -->
            </div>
        </div>
    </section>

    <!-- Mars Section -->
    <section id="mars" class="planet-section">
        <div class="particles" id="mars-particles"></div>
        <div class="planet-container">
            <div class="planet-info">
                <h2 class="planet-title">Mars</h2>
                <p class="planet-description">The Red Planet, a world of ancient river valleys and giant volcanoes. With its thin atmosphere and polar ice caps, Mars stands as humanity's next frontier in space exploration and potential future home.</p>
                <div class="planet-facts">
                    <div class="fact"><i class="fas fa-mountain"></i> Olympus Mons</div>
                    <div class="fact"><i class="fas fa-wind"></i> Thin Atmosphere</div>
                    <div class="fact"><i class="fas fa-expand-arrows-alt"></i> Diameter: 6,779 km</div>
                    <div class="fact"><i class="fas fa-satellite"></i> 2 Moons</div>
                </div>
            </div>
            <div class="planet-model" id="mars-model">
                <!-- 3D model will be rendered here -->
            </div>
        </div>
    </section>

    <!-- Jupiter Section -->
    <section id="jupiter" class="planet-section">
        <div class="particles" id="jupiter-particles"></div>
        <div class="planet-container">
            <div class="planet-info">
                <h2 class="planet-title">Jupiter</h2>
                <p class="planet-description">The king of planets, a gas giant so massive that all other planets could fit inside it. Jupiter's Great Red Spot is a storm larger than Earth that has raged for centuries, while its numerous moons include worlds that might harbor life.</p>
                <div class="planet-facts">
                    <div class="fact"><i class="fas fa-weight-hanging"></i> Mass: 318 Earths</div>
                    <div class="fact"><i class="fas fa-hurricane"></i> Great Red Spot</div>
                    <div class="fact"><i class="fas fa-expand-arrows-alt"></i> Diameter: 139,820 km</div>
                    <div class="fact"><i class="fas fa-moon"></i> 95 Moons</div>
                </div>
            </div>
            <div class="planet-model" id="jupiter-model">
                <!-- 3D model will be rendered here -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <h3>CosmicExplorer</h3>
            <p>Discover the wonders of our cosmic neighborhood</p>
            <div class="footer-links">
                <a href="#intro">Home</a>
                <a href="#mercury">Planets</a>
                <a href="#">Galaxies</a>
                <a href="#">Black Holes</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
            <div class="copyright">
                &copy; 2024 CosmicExplorer. Journey through the stars.
            </div>
        </div>
    </footer>

    <script>
        // Create animated stars
        function createStars() {
            const starsContainer = document.getElementById('stars');
            const starCount = 500;
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.classList.add('star');
                
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const size = Math.random() * 3 + 1;
                const duration = Math.random() * 5 + 3;
                const delay = Math.random() * 8;
                
                star.style.left = `${x}%`;
                star.style.top = `${y}%`;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                star.style.animationDuration = `${duration}s`;
                star.style.animationDelay = `${delay}s`;
                star.style.setProperty('--duration', `${duration}s`);
                
                starsContainer.appendChild(star);
            }
        }

        // Create shooting stars
        function createShootingStars() {
            setInterval(() => {
                if (Math.random() > 0.5) {
                    const shootingStar = document.createElement('div');
                    shootingStar.classList.add('shooting-star');
                    
                    const x = Math.random() * 20;
                    const y = Math.random() * 20;
                    const duration = Math.random() * 2 + 1;
                    
                    shootingStar.style.left = `${x}%`;
                    shootingStar.style.top = `${y}%`;
                    shootingStar.style.animationDuration = `${duration}s`;
                    
                    document.querySelector('.stars').appendChild(shootingStar);
                    
                    setTimeout(() => {
                        shootingStar.remove();
                    }, duration * 1000);
                }
            }, 1500);
        }

        // Create floating particles for each planet
        function createParticles() {
            const planets = ['mercury', 'venus', 'earth', 'mars', 'jupiter'];
            
            planets.forEach(planet => {
                const container = document.getElementById(`${planet}-particles`);
                if (!container) return;
                
                const particleCount = 25;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    const size = Math.random() * 6 + 2;
                    const left = Math.random() * 100;
                    const duration = Math.random() * 15 + 10;
                    const delay = Math.random() * 15;
                    
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.left = `${left}%`;
                    particle.style.top = `100%`;
                    particle.style.animationDuration = `${duration}s`;
                    particle.style.animationDelay = `${delay}s`;
                    
                    container.appendChild(particle);
                }
            });
        }

        // Scroll animations with Intersection Observer
        function initScrollAnimations() {
            const sections = document.querySelectorAll('section');
            const nav = document.getElementById('navbar');
            
            let lastScrollY = window.scrollY;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.3 });
            
            sections.forEach(section => {
                observer.observe(section);
            });
            
            window.addEventListener('scroll', () => {
                // Hide nav on scroll down
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    nav.classList.add('hidden');
                } else {
                    nav.classList.remove('hidden');
                }
                lastScrollY = window.scrollY;
            });
        }

        // Create realistic planet textures using shaders
        function createRealisticPlanet(containerId, params) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // Clear container
            container.innerHTML = '';
            
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ 
                alpha: true, 
                antialias: true,
                powerPreference: "high-performance"
            });
            
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setClearColor(0x000000, 0);
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            container.appendChild(renderer.domElement);
            
            // Create planet with detailed texture
            const geometry = new THREE.SphereGeometry(params.size, 128, 128);
            
            // Create dynamic material with multiple features
            const material = new THREE.MeshPhongMaterial({
                color: params.color,
                shininess: params.shininess || 30,
                specular: params.specular || 0x222222,
                bumpScale: params.bumpScale || 0.05,
                transparent: true,
                opacity: 1
            });
            
            // Add surface details programmatically
            if (params.surfaceDetail) {
                const vertices = geometry.attributes.position.array;
                const colors = [];
                
                for (let i = 0; i < vertices.length; i += 3) {
                    const x = vertices[i];
                    const y = vertices[i + 1];
                    const z = vertices[i + 2];
                    
                    // Create surface variations
                    const noise = Math.sin(x * 10) * Math.cos(y * 10) * Math.sin(z * 10);
                    const variation = params.surfaceDetail * noise;
                    
                    vertices[i + 2] += variation;
                    
                    // Add color variations
                    const colorVariation = Math.random() * 0.2;
                    colors.push(
                        params.color.r + colorVariation,
                        params.color.g + colorVariation, 
                        params.color.b + colorVariation
                    );
                }
                
                geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));
                material.vertexColors = true;
            }
            
            const planet = new THREE.Mesh(geometry, material);
            planet.castShadow = true;
            planet.receiveShadow = true;
            scene.add(planet);
            
            // Add atmosphere if specified
            if (params.atmosphere) {
                const atmosphereGeometry = new THREE.SphereGeometry(params.size * 1.05, 64, 64);
                const atmosphereMaterial = new THREE.MeshPhongMaterial({
                    color: params.atmosphere.color,
                    transparent: true,
                    opacity: params.atmosphere.opacity,
                    side: THREE.BackSide
                });
                const atmosphere = new THREE.Mesh(atmosphereGeometry, atmosphereMaterial);
                scene.add(atmosphere);
            }
            
            // Add rings for gas giants
            if (params.rings) {
                const ringGeometry = new THREE.RingGeometry(params.size * 1.4, params.size * 2.2, 128);
                const ringMaterial = new THREE.MeshPhongMaterial({
                    color: params.rings.color,
                    side: THREE.DoubleSide,
                    transparent: true,
                    opacity: params.rings.opacity,
                    shininess: 100
                });
                const rings = new THREE.Mesh(ringGeometry, ringMaterial);
                rings.rotation.x = Math.PI / 2 + params.rings.tilt;
                rings.castShadow = true;
                scene.add(rings);
            }
            
            // Enhanced lighting setup
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
            scene.add(ambientLight);
            
            const mainLight = new THREE.DirectionalLight(0xffffff, 1);
            mainLight.position.set(10, 5, 7);
            mainLight.castShadow = true;
            mainLight.shadow.mapSize.width = 2048;
            mainLight.shadow.mapSize.height = 2048;
            scene.add(mainLight);
            
            const fillLight = new THREE.DirectionalLight(0xffffff, 0.5);
            fillLight.position.set(-5, 3, -5);
            scene.add(fillLight);
            
            const pointLight = new THREE.PointLight(params.color, 0.8, 100);
            pointLight.position.set(15, 10, 15);
            scene.add(pointLight);
            
            camera.position.z = params.size * 3.5;
            
            // Add orbit controls for interactive viewing
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.rotateSpeed = 0.5;
            controls.enableZoom = false;
            controls.enablePan = false;
            
            // Auto-rotation with mouse interaction
            let autoRotate = true;
            let mouseX = 0;
            let mouseY = 0;
            
            container.addEventListener('mouseenter', () => {
                autoRotate = false;
                controls.enabled = true;
            });
            
            container.addEventListener('mouseleave', () => {
                autoRotate = true;
                controls.enabled = false;
            });
            
            container.addEventListener('mousemove', (event) => {
                if (!autoRotate) {
                    mouseX = (event.clientX / window.innerWidth) * 2 - 1;
                    mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
                }
            });
            
            // Animation loop
            function animate() {
                requestAnimationFrame(animate);
                
                if (autoRotate) {
                    planet.rotation.y += 0.008;
                    if (params.rings) {
                        const rings = scene.children.find(child => child.geometry instanceof THREE.RingGeometry);
                        if (rings) rings.rotation.z += 0.002;
                    }
                } else {
                    controls.update();
                }
                
                // Subtle floating animation
                planet.position.y = Math.sin(Date.now() * 0.001) * 0.1;
                
                renderer.render(scene, camera);
            }
            
            animate();
            
            // Handle resize
            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });
        }

        // Planet configurations with realistic parameters
        const planetConfigs = {
            'mercury-model': {
                size: 1.2,
                color: new THREE.Color(0x8C7853),
                shininess: 20,
                specular: 0x111111,
                surfaceDetail: 0.03,
                bumpScale: 0.02
            },
            'venus-model': {
                size: 1.5,
                color: new THREE.Color(0xE39E54),
                shininess: 50,
                specular: 0x333333,
                surfaceDetail: 0.02,
                atmosphere: {
                    color: 0xFFA500,
                    opacity: 0.3
                }
            },
            'earth-model': {
                size: 1.6,
                color: new THREE.Color(0x6B93D6),
                shininess: 80,
                specular: 0x444444,
                surfaceDetail: 0.04,
                atmosphere: {
                    color: 0x87CEEB,
                    opacity: 0.4
                }
            },
            'mars-model': {
                size: 1.3,
                color: new THREE.Color(0xCD5C5C),
                shininess: 30,
                specular: 0x222222,
                surfaceDetail: 0.05,
                bumpScale: 0.03
            },
            'jupiter-model': {
                size: 2.5,
                color: new THREE.Color(0xC19E6B),
                shininess: 100,
                specular: 0x555555,
                surfaceDetail: 0.08,
                rings: {
                    color: 0x8B7355,
                    opacity: 0.6,
                    tilt: 0.1
                }
            }
        };

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            createShootingStars();
            createParticles();
            initScrollAnimations();
            
            // Create realistic planet models
            setTimeout(() => {
                Object.keys(planetConfigs).forEach(containerId => {
                    createRealisticPlanet(containerId, planetConfigs[containerId]);
                });
            }, 1000);
        });
    </script>
</body>
</html>