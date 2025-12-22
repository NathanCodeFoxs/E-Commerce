<?php
require_once __DIR__ . "/PHP/auth.php";
require_once __DIR__ . "/PHP/db.php";

$user_id = $_SESSION['user_id'];

// Fetch available balance
$stmt = $conn->prepare("SELECT balance FROM balances WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

// Safety fallback
$balance = $balance ?? 0;

// Percentage allocation
$budgeting       = $balance * 0.40;
$emergencyFund   = $balance * 0.20;
$savings         = $balance * 0.25;
$insurance       = $balance * 0.10;
$taxPlanning     = $balance * 0.05;

// Fix rounding so total is EXACT
$totalAllocated =
    $budgeting +
    $emergencyFund +
    $savings +
    $insurance +
    $taxPlanning;

$roundingFix = $balance - $totalAllocated;
$taxPlanning += $roundingFix;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finance</title>
  <style>
    /* Global font + background */
    body {
      font-family: "Georgia", "Times New Roman", serif;
      margin: 0;
      background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
      color: #FFFFFF;
    }

    /* Header */
    .header {
      background-color: rgba(11, 48, 55, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 34px;
      font-weight: bold;
      position: relative;
    }

    .nav-head {
      width: 100%;
      height: 80px;
      background: transparent;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-title {
      font-size: 40px;
      font-weight: 600;
      color: #FFFFFF;
      font-family: "Georgia", "Times New Roman", serif;
    }

    /* Sidebar */
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

    .header {
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
      font-size: 18px; /* unified font size */
      text-decoration: none;
      cursor: pointer;
      font-family: "Georgia", "Times New Roman", serif;
    }

    .sidebar img {
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
      visibility: hidden;
    }

    /* Card + Table */
    .card {
      width: 700px;
      margin: 60px auto;
      padding: 30px;
      background-color: rgba(11, 48, 55, 0.8);
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      font-family: "Georgia", "Times New Roman", serif;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: left;
      font-size: 18px; /* unified table font size */
      border-bottom: 1px solid #AC8F45;
      font-family: "Georgia", "Times New Roman", serif;
    }

    th {
      background-color: #0B3037;
      color: #AC8F45;
      font-size: 20px; /* slightly larger for headers */
    }

    td {
      color: #FFFFFF;
    }

    .total-row {
      font-weight: bold;
      background-color: #0B3037;
    }

    .total-cell {
      font-size: 22px; /* highlight total */
      color: #AC8F45;
    }
  </style>
</head>
<body>

<!-- ======[ SIDEBAR ]====== -->
<div class="header">
  <div class="sidebar-bg" id="sidebarBg" onclick="closeSidebar()">
    <div class="sidebar" id="sidebar" onclick="event.stopPropagation()">
      <a onclick="goTo('Dashboard.php')"><img src="Images/home.png" alt="" width="20"> Dashboard</a>
      <a onclick="goTo('Transfer.php')"><img src="Images/Transfer.png" width="20"> Transfer</a>
      <a onclick="goTo('Bills.php')"><img src="Images/Bill.png" width="20"> Bills</a>
      <a onclick="goTo('Deposit.php')"><img src="Images/Safe_In.png" width="20"> Deposit</a>
      <a onclick="goTo('Withdrawal.php')"><img src="Images/Safe_Out.png" width="20"> Withdrawal</a>
      <a onclick="goTo('Finance.php')"><img src="Images/Finance.png" width="20"> Finance</a>
      <a onclick="goTo('Profile_Info.php')"><img src="Images/Setting.png" alt="" width="20"> Settings</a>
      <a onclick="goTo('PHP/logout.php')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
    </div>
  </div>

  <!-- =====[ NAVBAR ]===== -->
  <div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
    <span class="header-title">Finance</span>
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
      <td>Budgeting (40%)</td>
      <td>₱ <?= number_format($budgeting, 2) ?></td>
    </tr>
    <tr>
      <td>Emergency Fund (20%)</td>
      <td>₱ <?= number_format($emergencyFund, 2) ?></td>
    </tr>
    <tr>
      <td>Savings (25%)</td>
      <td>₱ <?= number_format($savings, 2) ?></td>
    </tr>
    <tr>
      <td>Insurance (10%)</td>
      <td>₱ <?= number_format($insurance, 2) ?></td>
    </tr>
    <tr>
      <td>Tax Planning (5%)</td>
      <td>₱ <?= number_format($taxPlanning, 2) ?></td>
    </tr>
    <tr class="total-row">
      <td>Total:</td>
      <td class="total-cell">₱ <?= number_format($balance, 2) ?></td>
    </tr>
  </table>
</div>

<script src="Dashboard.js"></script>
</body>
</html>
