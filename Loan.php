<?php require_once __DIR__ . "/PHP/auth.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Loan</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Georgia", "Times New Roman", serif;
    }

    body {
      background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
      height: 100vh;
      display: flex;
      flex-direction: column;
      color: #f5f5f5;
    }

    .header-title {
      font-size: 40px;
      font-family: "Georgia", "Times New Roman", serif;
      font-weight: 600;
      color: #FFFFFF;
    }

    .page-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      width: 420px;
      background: #052c35;
      border-radius: 6px;
      padding: 40px 40px 32px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      text-align: center;
    }

    .field-label {
      text-align: left;
      font-size: 13px;
      margin-bottom: 6px;
    }

    .amount-input {
      width: 100%;
      padding: 10px 8px;
      border-radius: 2px;
      border: 1px solid #c09b3f;
      background: transparent;
      color: #f5f5f5;
      outline: none;
      margin-bottom: 28px;
    }

    .amount-input::placeholder {
      color: #b0b0b0;
    }

    .section-title {
      font-size: 22px;
      color: #c7a043;
      border-bottom: 1px solid #c7a043;
      padding-bottom: 6px;
      margin-bottom: 18px;
    }

    .details-box {
      width: 100%;
      background: #e3e3e3;
      padding: 0 14px 14px;
      text-align: left;
      font-size: 14px;
      border-bottom: 1px solid #d3d3d3;
      color: #b9913a;
      border-radius: 1em;
      overflow: hidden;
    }

    .details-header {
      height: 8px;
      background-color: #c7a043;
      margin: 0 -14px 8px;
    }

    .detail-row {
      margin-bottom: 10px;
    }

    .detail-row:last-child {
      margin-bottom: 0;
    }

    .detail-label {
      display: block;
      margin-bottom: 4px;
    }

    .detail-input {
      width: 100%;
      padding: 6px 8px;
      border-radius: 1px;
      border: 1px solid #c09b3f;
      background: #f6f6f6;
      color: #333;
      outline: none;
      font-size: 13px;
    }

    .confirm-btn {
      margin-top: 28px;
      background: #c39d45;
      border: none;
      color: #f5f5f5;
      padding: 10px 40px;
      border-radius: 20px;
      font-size: 15px;
      cursor: pointer;
    }

    .confirm-btn:hover {
      background: #b18c39;
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

.nav-head{
    width: 100%;
    height: 80px;
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
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
        <a onclick="goTo('logout.php')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
    </div>
</div>

<!-- =====[ NAVBAR ]===== -->
<div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
        <span class="header-title">Loan</span>
        <span class="bell-icon">
            <img src="Images/Notification.png" alt="notification" width="30">
        </span>
    </div>
</div>

  <main class="page-wrapper">
    <div class="card">
      <div class="field-label">Request Amount</div>
      <input
        type="text"
        class="amount-input"
        placeholder="Enter amount"
      />

      <div class="section-title">Loan Details</div> 

      <div class="details-box">
        <div class="details-header"></div>

        <div class="detail-row">
          <span class="detail-label">Deadline Payment</span>
          <input
            type="text"
            class="detail-input"
            placeholder="this should be a date"
          />
        </div>

        <div class="detail-row">
          <span class="detail-label">Request Amount</span>
          <input
            type="text"
            class="detail-input"
            placeholder="Enter amount"
          />
        </div>
      </div>

      <button class="confirm-btn">Confirm</button>
    </div>
  </main>
</body>
<script src="Dashboard.js">

</script>
</html>
