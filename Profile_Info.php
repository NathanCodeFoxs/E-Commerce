<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Info</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #0d4d56 0%, #1a5f6a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .header-icon:hover {
            transform: scale(1.1);
        }

        .header-icon svg {
            width: 35px;
            height: 35px;
            fill: #0d4d56;
        }

        .title {
            color: white;
            font-size: 3rem;
            font-weight: 400;
            text-align: center;
            flex: 1;
        }

        .notification-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .notification-icon svg {
            width: 35px;
            height: 35px;
            fill: white;
        }

        .content-card {
            background: rgba(13, 77, 86, 0.6);
            border-radius: 20px;
            padding: 60px;
            backdrop-filter: blur(10px);
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 40px;
            overflow: hidden;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .field-group {
            margin-bottom: 40px;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            color: white;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 400;
        }

        .field-value {
            background: transparent;
            border: 2px solid #c9a961;
            color: white;
            padding: 18px 25px;
            font-size: 1.2rem;
            text-align: center;
            border-radius: 5px;
            font-family: 'Georgia', serif;
            width: 100%;
        }

        @media (max-width: 768px) {
            .title {
                font-size: 2rem;
            }

            .content-card {
                padding: 40px 30px;
            }

            .header-icon {
                width: 50px;
                height: 50px;
            }

            .header-icon svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon" onclick="window.location.href='profile-info.html'">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <h1 class="title">Profile Info</h1>
            <div class="notification-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                </svg>
            </div>
        </div>

        <div class="content-card">
            <div class="profile-avatar">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230d4d56'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" alt="Profile">
            </div>

            <div class="field-group">
                <div class="field-label">Account Name</div>
                <div class="field-value">Jake</div>
            </div>

            <div class="field-group">
                <div class="field-label">Account Number</div>
                <div class="field-value">09235212104</div>
            </div>
        </div>
    </div>

    <script>
        // Click user icon to go to settings
        document.querySelector('.header-icon').addEventListener('click', function() {
            window.location.href = 'Profile_Settings.html';
        });
    </script>
</body>
</html>