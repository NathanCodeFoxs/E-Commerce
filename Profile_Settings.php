<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
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

        input.field-value {
            outline: none;
        }

        input.field-value:focus {
            border-color: #d4b76a;
        }

        .change-btn {
            background: #c9a961;
            border: none;
            color: white;
            padding: 18px 25px;
            font-size: 1.2rem;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-family: 'Georgia', serif;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .change-btn:hover {
            background: #b89850;
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
            <div class="header-icon" onclick="window.location.href='profile-settings.html'">
                <svg viewBox="0 0 24 24">
                    <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                </svg>
            </div>
            <h1 class="title">Profile Settings</h1>
            <div class="notification-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                </svg>
            </div>
        </div>

        <div class="content-card">
            <div class="field-group">
                <div class="field-label">Password</div>
                <input type="password" class="field-value" value="***************************" readonly>
                <button class="change-btn" onclick="changePassword()">Change</button>
            </div>

            <div class="field-group">
                <div class="field-label">Phone Number</div>
                <input type="text" class="field-value" id="phoneInput" value="0921 514 2155">
                <button class="change-btn" onclick="changePhone()">Change</button>
            </div>

            <div class="field-group">
                <div class="field-label">Pin</div>
                <input type="password" class="field-value" id="pinInput" value="0000" maxlength="4">
                <button class="change-btn" onclick="changePin()">Change</button>
            </div>

            <div class="field-group">
                <div class="field-label">Email</div>
                <input type="email" class="field-value" id="emailInput" value="drdizalthe2nd@gmail.com.">
                <button class="change-btn" onclick="changeEmail()">Change</button>
            </div>
        </div>
    </div>

    <script>
        // Click settings icon to go back to profile info
        document.querySelector('.header-icon').addEventListener('click', function() {
            window.location.href = 'Profile_Info.html';
        });

        function changePassword() {
            const newPassword = prompt('Enter new password:');
            if (newPassword) {
                alert('Password changed successfully!');
            }
        }

        function changePhone() {
            const phone = document.getElementById('phoneInput').value;
            alert('Phone number updated to: ' + phone);
        }

        function changePin() {
            const pin = document.getElementById('pinInput').value;
            if (pin.length !== 4) {
                alert('PIN must be 4 digits');
                return;
            }
            alert('PIN changed successfully!');
        }

        function changeEmail() {
            const email = document.getElementById('emailInput').value;
            if (email.includes('@')) {
                alert('Email updated to: ' + email);
            } else {
                alert('Please enter a valid email address');
            }
        }
    </script>
</body>
</html>