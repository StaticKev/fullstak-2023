<style>
    .navbar {
        background: rgba(20, 20, 20, 0.9);
        backdrop-filter: blur(8px);
        padding: 20px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 0 10px #ffffff33;
        animation: glow 2s infinite alternate;
    }

    @keyframes glow {
        0%   { box-shadow: 0 0 6px #ffffff33; }
        50%  { box-shadow: 0 0 12px #ffffff99; }
        100% { box-shadow: 0 0 6px #ffffff33; }
    }

    .navbar a {
        color: #fff;
        text-decoration: none;
        margin: 0 25px; 
        font-family: 'Segoe UI', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        transition: color 0.3s, transform 0.2s;
    }

    .navbar a:hover {
        color: #00bcd4;
        transform: scale(1.1);
    }

    .navbar h1 {
        color: #fff;
        margin: 0;
        font-size: 22px;
        letter-spacing: 1px;
    }

    .nav-links {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="navbar">
    <div class="nav-links">
        <a href="index.php">🏠 Home</a>
        <a href="tampilandosen.php">👨‍🏫 Dosen</a>
        <a href="tampilanmahasiswa.php">🎓 Mahasiswa</a>
        <?php if (isset($_SESSION['login'])): ?>
            <a href="logout.php">🚪 Logout</a>
        <?php endif; ?>
    </div>
</div>
