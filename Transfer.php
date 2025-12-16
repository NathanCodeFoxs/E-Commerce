<?php require_once __DIR__ . "/PHP/auth.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Transfer</title>

<style>
    body {
        margin: 0;
        font-family: "Georgia", "Times New Roman", serif;
        background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
        color: #FFFFFF;
    }
    .header{
    width: 100%;
    height: 100px;
    background: #0b2931;
    display: flex;
    align-items: center;
    margin-bottom: 50px;
}
    .nav-head{
    width: 100%;
    height: 80px;
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

    .header-title {
        font-size: 40px;
        font-family: "Georgia", "Times New Roman", serif;
        font-weight: 600;
        color: #FFFFFF;
    }

    .header-img-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .left-btn img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .right-btn img {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    .left-btn { 
    left: 15px;
    }

    .right-btn {    
    right: 15px;
    }

    .header-btn:hover {
        background-color: #0B3037;
    }

    .section-title {
        text-align: center;
        color: #e7c97a;
        font-size: 20px;
        background-color: #0B3037;
        padding: 10px 0;
        margin: 0;
        border-bottom: 1px solid #163F48;
        width: 100%;
        border-radius: 6px 6px 0 0;
    }


    .table-box table {
        width: 100%;
        border-collapse: collapse;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #FFFFFF;
        color: #000000;
    }

    .table-scroll {
        max-height: 170px;
        overflow-y: auto;
    }

    thead {
        background-color: rgba(11, 48, 55, 0.8);
        color: #AC8F45;
        font-weight: bold;
    }

    th, td {
        padding: 10px;
        border: 1px solid #cccccc;
        text-align: center;
    }

    .options-title {
        margin-top: 30px;
        text-align: center;
        font-size: 60px;
        font-weight: bold;
        padding: 15px 30px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 50px;
        border-radius: 20px;
        background-color: rgba(11, 48, 55, 0.8);
    }

    .options-container {
        display: flex;
        justify-content: center;
        gap: 80px;
        margin-top: 25px;
        margin-bottom: 50px;
    }

    .option-box {
        background-color: rgba(11, 48, 55, 0.8);
        width: 130px;
        height: 130px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #FFFFFF;
        font-size: 14px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }

    .option-box:hover {
        background-color: #0B3037;
        transform: scale(1.05);
    }

    .option-box img.icon {
        width: 45px;
        height: 45px;
        margin-bottom: 8px;
    }

    .icon {
        width: 90px;
        height: 90px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .history-box {
        max-width: 900px;
        margin: 0 auto;
        background: #0B3037;
        border: 1px solid #163F48;
        border-radius: 6px;
        padding: 5px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    }

    /* Remove table's own border so it blends inside the box */
    .history-box table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Header row styling */
    .history-box thead tr {
        background: #0E3A48;
    }

    .history-box th {
        padding: 10px;
        border-bottom: 1px solid #163F48;
        text-align: left;
        font-weight: bold;
    }

    .history-box td {
        padding: 8px 10px;
        border-bottom: 1px solid #1A454E;
    }

    .history-box th, .history-box td {
        padding: 6px 8px; /* smaller than 10px */
        font-size: 13px;  /* match Bills */
    }

    .pay-options-header-wrap {
        display: flex;
        justify-content: center;
        margin: 70px 0 16px;
        margin-bottom: 40px;
    }

    .pay-options-header {
        background: #03242e;
        padding: 12px 80px;
        border-radius: 50px;
        font-size: 26px;
        font-weight: 600;
        color: #f7f5e9;
        box-shadow: 0 4px 14px rgba(0,0,0,0.6);
    }

    .cards-row {
        display: flex;
        justify-content: center;
        gap: 100px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .bill-card {
        width: 150px;
        text-align: center;
        transition: 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .bill-card-top {
        background: #022933;
        border-radius: 12px 12px 0 0;
        padding: 18px 10px 22px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.7);
    }

    .bill-icon img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        margin-bottom: 8px;
    }

    .bill-label {
        font-size: 14px;
        color: #FFFFFF;
    }

    .bill-card:hover {
        transform: translateY(-8px) scale(1.05);
    }

    .bill-card:hover .bill-card-top {
        box-shadow: 0 6px 20px rgba(0,0,0,0.8);
        background: #033543;
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

.sidebar {
    width: 280px;
    height: 100%;
    background: #0b1f29;
    position: absolute;
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

</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
        <div class="sidebar-bg" id="sidebarBg" onclick="closeSidebar()">
    <div class="sidebar" id="sidebar" onclick="event.stopPropagation()">
        <a onclick="goTo('Dashboard.php')" ><img src="Images/home.png" alt="" width="20"> Dashboard</a>
        <a onclick="goTo('Transfer.php')"><img src="Images/Transfer.png" width="20"> Transfer</a>
        <a onclick="goTo('bills.html')"><img src="Images/Bill.png" width="20"> Bills</a>
        <a onclick="goTo('loan.html')"><img src="Images/Loan.png" width="20"> Loan</a>
        <a onclick="openDeposit()"><img src="Images/Safe_In.png" width="20"> Deposit</a>
        <a onclick="goTo('withdraw.html')"><img src="Images/Safe_Out.png" width="20"> Withdrawal</a>
        <a onclick="goTo('finance.html')"><img src="Images/Finance.png" width="20"> Finance</a>
        <a onclick="goTo('settings.html')"><img src="Images/Setting.png" alt="" width="20"> Settings</a>
        <a onclick="goTo('logout.html')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
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

<!-- TRANSACTION HISTORY -->
<div class="history-box">
<div class="section-title">Transaction History</div>

 <div class="table-scroll" style="max-height: 150px; overflow-y: auto;">
    <table>
        <thead>
            <tr>
                <th>Bank</th>
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="history-body">
            <!-- Dynamic rows OUTPUT-->
        </tbody>
    </table>
</div>
</div>

<!-- TRANSFER OPTIONS -->
<div class="pay-options-header-wrap">
    <div class="pay-options-header">Transfer Options</div>
</div>

<div class="cards-row">
    <a href="Bank_Transfer.php" class="bill-card">
        <div class="bill-card-top">
            <div class="bill-icon"><img src="Images/Bank_Transfer.png" alt=""></div>
            <div class="bill-label">Bank Transfer</div>
        </div>
    </a>

    <a href="Money_Transfer.php" class="bill-card">
        <div class="bill-card-top">
            <div class="bill-icon"><img src="Images/Money_Transfer.png" alt=""></div>
            <div class="bill-label">Money Transfer</div>
        </div>
    </a>
</div>

<script src="Dashboard.js">
</script>

</body>
</html>