<!DOCTYPE html>
<html>
<head>
    <title>Notes Circle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar custom-nav">
        <div class="container">
            <div class="logo-section">
                <img src="../uploads/logo.jpeg">
                <span>Notes&nbsp;Circle</span>
            </div>
            <div>
                <a href="../user/login.php" class="btn btn-login">Login</a>
                <a href="../user/register.php" class="btn btn-register">Register</a>
            </div>
        </div>
    </nav>
    <!-- HERO -->
    <section class="hero text-center">
        <div class="container">
            <h1>Welcome to Notes Circle 🐼</h1>
            <h2 class="typing"></h2>
            <p>Keep your notes safe, organized and easy to access...</p>
            <a href="../user/register.php" class="btn btn-main mt-4">Get Started</a>
        </div>
    </section>
    <!-- ABOUT -->
    <section class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="about-title">About Notes Circle</h2>
                    <p>Notes Circle is a web-based platform designed for students to upload, organize, share, and
                        download study notes with ease 📚✨. It provides a simple and structured system where all your
                        study material stays in one place, making it easy to manage and access anytime ⏱️.
                    </p>
                    <p>Whether it’s storing your own notes or exploring useful content shared by others, Notes Circle
                        helps you stay organized and focused 🎯. With a smooth and user-friendly experience, it makes
                        studying more efficient, less confusing, and a lot more convenient 💫.</p>
                    <p>Making your study journey simpler and smarter every day 🌿</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="../uploads/hero.jpeg" class="about-img img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- WHY -->
    <section class="why">
        <div class="container">
            <h2 class="text-center mb-4 why-heading">Why Notes Circle?</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5 style="color: red;">❌ Problems</h5>
                    <ul>
                        <li>Notes scattered 📄</li>
                        <li>Hard to find quickly ⏳</li>
                        <li>Limited shared content 📉</li>
                        <li>Messy management 🌀</li>
                        <li>Too many files 📂</li>
                        <li>No proper structure ❌</li>
                        <li>Time wasted searching ⏱️</li>
                        <li>Confusing storage 🤯</li>
                        <li>No easy access 🚫</li>
                        <li>Unorganized study flow 🔄</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 style="color: green;">✅ Solutions</h5>
                    <ul>
                        <li>One place storage 📚</li>
                        <li>Quick access ⏱️</li>
                        <li>Easy sharing & download 🤝</li>
                        <li>Simple organization 💫</li>
                        <li>All files together 📂</li>
                        <li>Clean structure ✔️</li>
                        <li>Saves time ⚡</li>
                        <li>Easy navigation 🔍</li>
                        <li>Access anytime 🌐</li>
                        <li>Smooth study flow ✨</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ -->
    <section class="faq">
        <div class="container">
            <h2 class="faq-title text-center mb-4">Frequently Asked Questions</h2>
            <div class="faq-box">
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-indian-rupee-sign"></i> &nbsp; Is Notes Circle free to use?
                            💸</span>
                        <span class="icon">+</span>
                    </button>
                    <div class="faq-answer"><i class="fa-solid fa-circle-check"></i> &nbsp;
                        Yes, Notes Circle is completely free and accessible for all students.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-book-open-reader"></i> &nbsp; What can I do on Notes Circle?
                            📚</span>
                        <span class="icon">+</span>
                    </button>
                    <div class="faq-answer"><i class="fa-solid fa-circle-check"></i> &nbsp;
                        You can upload your notes, organize them easily, and also download useful study material shared
                        by others.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-user-plus"></i> &nbsp; Do I need an account to use it? 🔐</span>
                        <span class="icon">+</span>
                    </button>
                    <div class="faq-answer"><i class="fa-solid fa-circle-check"></i> &nbsp;
                        Yes, you need to register and login to upload, manage, and access notes securely.
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer text-center">
        ❤️ © 2026 Notes Circle. Designed & Developed by Anushka Sharma.❤️
    </footer>
    <script src="../js/home.js"></script>
</body>
</html>