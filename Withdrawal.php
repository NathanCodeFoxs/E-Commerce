<?php require_once __DIR__ . "/PHP/auth.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Withdrawal</title>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
        overflow: hidden;
        background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
        color: white;
    }

    .top-header {
        height: 80px;
        background: #0B3037;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        border-bottom: 2px solid rgba(255, 255, 255, 0.15);
    }

    .nav-head{
    width: 100%;
    height: 80px;
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    }

    .icon-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        background: #0c3d4a;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .left { left: 30px; }
    .right { right: 30px; }

    .top-header h1 {
        font-size: 50px;
        font-weight: 600;
        font-family: "Georgia", "Times New Roman", serif;
    }

    .card {
        width: 450px;
        margin: 90px auto 0;
        padding: 40px 45px 120px;
        background: rgba(0, 0, 0, 0.32);
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.35);
    }

    .balance-box {
        background: #AC8F45;
        padding: 18px 12px;
        border-radius: 18px;
        margin-bottom: 40px;
        color: #073c45;
    }

    .balance-label {
        font-size: 12px;
        letter-spacing: 1px;
    }

    .balance-value {
        font-size: 38px;
        font-weight: 600;
        color: white;
        margin-top: 5px;
    }

    .input-wrap {
        width: 80%;
        margin: 0 auto 30px;
        text-align: left;
    }

    .label {
        font-size: 14px;
        margin-bottom: 8px;
    }

    input {
        width: 100%;
        padding: 14px;
        border-radius: 6px;
        background: transparent;
        border: 2px solid #AC8F45;
        color: white;
        font-size: 16px;
        outline: none;
    }

    button {
        width: 80%;
        padding: 13px;
        background: #AC8F45;
        border: none;
        border-radius: 10px;
        font-size: 17px;
        font-weight: bold;
        color: #073c45;
        cursor: pointer;
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
<div class="header">
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
        <a onclick="goTo('PHP/logout.php')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
    </div>
</div>

<!-- =====[ NAVBAR ]===== -->
<div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
        <span class="header-title">Withdrawal</span>
        <span class="bell-icon">
            <img src="Images/Notification.png" alt="notification" width="30">
        </span>
    </div>
</div>

<div class="card">

    <div class="balance-box">
        <div class="balance-label">AVAILABLE BALANCE</div>
        <div class="balance-value" id="balance">₱ 0000.00</div>
    </div>

    <div class="input-wrap">
        <div class="label">Withdrawal Amount</div>
        <input type="number" placeholder="Enter amount">
    </div>

    <button>Confirm</button>
</div>
</body>
<script src="Dashboard.js"></script>
</html>
