<?php require_once __DIR__ . "/PHP/auth.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
            color: #FFFFFF;
        }

        .header {
            background-color: rgba(11, 48, 55, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 34px;
            font-weight: bold;
            position: relative;
        }

        .header-title {
            color: #FFFFFF;
        }

        .header-img-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .left-btn img {
            width: 50px;
            height: 50px;
        }

        .right-btn img {
            width: 30px;
            height: 30px;
        }

        .left-btn { left: 15px; }
        .right-btn { right: 15px; }

        .card {
            width: 700px;
            margin: 60px auto;
            padding: 30px;
            background-color: rgba(11, 48, 55, 0.8);
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 18px;
            border-bottom: 1px solid #AC8F45;
        }

        th {
            background-color: #0B3037;
            color: #AC8F45;
        }

        td {
            color: #FFFFFF;
        }

        .total-row {
            font-weight: bold;
            background-color: #0B3037;
        }

        .total-cell {
            font-size: 24px;
            color: #AC8F45;
        }

                      /* ========[ SIDEBAR ]======== */
.sidebar-bg {
    position: fixed;
    top: 0; left: 0;
    width: 0;
    height: 100%;
    background: rgba(0,0,0,0.5);
    overflow: hidden;
    transition: 0.3s ease;
    z-index: 10;
}

.header{
    width: 100%;
    height: 100px;
    background: #0b2931;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sidebar {
    width: 280px;
    height: 100%;
    background: #0b1f29;
    left: -280px;
    top: 0;
    padding-top: 40px;
    transition: 0.3s ease;
    box-shadow: 2px 0 8px rgba(0,0,0,0.4);
}

.sidebar a {
    display: block;
    padding: 18px 30px;
    color: #ac8f45;
    font-size: 20px;
    text-decoration: none;
    cursor: pointer;
}

.sidebar img{
    margin-right: 15px;
    vertical-align: middle;
}

.sidebar a:hover {
    background: #10303a;
}

.menu-icon {
    font-size: 32px;
    cursor: pointer;
    color: white;
    margin-left: 20px;
}
.bell-icon {
    margin-right: 20px;
}
.title {
    font-size: 36px;
    font-weight: 600;
    letter-spacing: 1px;
}
    </style>
</head>
<body>

<!-- ======[ SIDEBAR ]====== -->
<div class="sidebar-bg" id="sidebarBg" onclick="closeSidebar()">
    <div class="sidebar" id="sidebar" onclick="event.stopPropagation()">
        <a onclick="goTo('Dashboard.php')" ><img src="Images/home.png" alt="" width="20"> Dashboard</a>
        <a onclick="goTo('Transfer.php')"><img src="Images/Transfer.png" width="20"> Transfer</a>
        <a onclick="goTo('Bills.php')"><img src="Images/Bill.png" width="20"> Bills</a>
        <a onclick="goTo('Loan.php')"><img src="Images/Loan.png" width="20"> Loan</a>
        <a onclick="goTo('Deposit.php')"><img src="Images/Safe_In.png" width="20"> Deposit</a>
        <a onclick="goTo('Withdrawal.php')"><img src="Images/Safe_Out.png" width="20"> Withdrawal</a>
        <a onclick="goTo('Finance.php')"><img src="Images/Finance.png" width="20"> Finance</a>
        <a onclick="goTo('settings.php')"><img src="Images/Setting.png" alt="" width="20"> Settings</a>
        <a onclick="goTo('logout.php')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
    </div>
</div>

<!-- =====[ NAVBAR ]===== -->
<div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
        <span class="header-title">Transfer</span>
        <span class="bell-icon">
            <img src="Images/Notification.png" alt="notification" width="30">
        </span>
    </div>
</div>

<div class="card">
    <table>
        <tr>
            <th>Category</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Income</td>
            <td>₱12,000</td>
        </tr>
        <tr>
            <td>Budgeting</td>
            <td>₱5,000</td>
        </tr>
        <tr>
            <td>Debt Management</td>
            <td>₱1,500</td>
        </tr>
        <tr>
            <td>Emergency Fund</td>
            <td>₱1,000</td>
        </tr>
        <tr>
            <td>Savings</td>
            <td>₱2,000</td>
        </tr>
        <tr>
            <td>Insurance</td>
            <td>₱500</td>
        </tr>
        <tr>
            <td>Tax Planning</td>
            <td>₱468</td>
        </tr>
        <tr class="total-row">
            <td>Total:</td>
            <td class="total-cell">₱15,532.43</td>
        </tr>
    </table>
</div>
</body>
<script src="Dashboard.js"> </script>
</html>