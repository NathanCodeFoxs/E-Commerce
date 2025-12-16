<?php
require_once __DIR__ . "/PHP/auth.php";   // session start & redirect if not logged in
require_once __DIR__ . "/PHP/db.php";     // database connection

// Get the logged-in user ID
$user_id = $_SESSION['user_id'] ?? null;

// Default balance
$balance = 0.00;

if ($user_id) {
    // Fetch balance from MySQL
    $stmt = $conn->prepare("SELECT balance FROM balances WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BBC Dashboard</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap">
<link rel="stylesheet" href="dashboard.css">

<script>
window.addEventListener("pageshow", function(event) {
    if (event.persisted || window.performance.getEntriesByType("navigation")[0].type === "back_forward") {
        window.location.href = 'Login.php';
    }
});
</script>

</head>
<style>
    body {
    margin: 0;
    padding: 0;
    font-family: "Times New Roman", serif;
    background: linear-gradient(to right, #134E5E,#0B3037);
    overflow: hidden;
}

/* =====[ NAVBAR ]===== */
.header{
    width: 100%;
    height: 100px;
    background: #0b2931;
    display: flex;
    align-items: center;
}

.header-logo{
    height: 80px;
    margin: 10px 10px;
}

.acro_compa{
    display: inline-block;
    background: linear-gradient(to right, #AC8F45, #6E5A27);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 28px;
    font-weight: bold;
    vertical-align: middle;
}
span{
    margin-left: auto;
    margin-right: 20px;
}

.menu-icon {
    font-size: 32px;
    cursor: pointer;
    color: white;
    margin-left: 20px;
}

.bbc-logo {
    display: flex;
    align-items: center;
    color: #ac8f45;
    font-size: 36px;
    font-weight: bold;
}

.bell-icon {
    font-size: 32px;
    color: #ac8f45;
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

a #active {
    background: #10303a;
    font-weight: bold;
}

/* =====[ BALANCE CARD ]===== */
.balance-container {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #0b2931;
    height: 310px;
    margin-top: 80px;
}

.balance-card {
    background: #ac8f45;
    width: 700px;
    height: 160px;
    border-radius: 18px;
    text-align: center;
    padding-top: 18px;
    box-sizing: border-box;
}

.balance-label {
    color: white;
    font-size: 20px;
    letter-spacing: 2px;
}

.eye-icon {
    margin-left: 5px;
    background-color: transparent;
    border: none;
    cursor: pointer;
}

.balance-amount {
    color: white;
    font-size: 64px;
    margin-top: 5px;
    margin-right: 25px;
}

/* =====[ ICON BUTTONS ]===== */
.icon-row {
    margin-top: 100px;
    display: flex;
    justify-content: space-around;
    padding: 0px 50px;
}

.icon-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.icon-btn img {
    width: 70px;
    height: 70px;
}

.icon-btn:hover {
    transform: scale(1.1);
}

/* =====[ POPUP ]===== */
.popup-bg {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    justify-content: center;
    align-items: center;
}

.popup-box {
    background: #ffffff;
    width: 350px;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    font-family: Arial;
}

.popup-box input {
    width: 80%;
    padding: 10px;
    font-size: 18px;
    margin-top: 15px;
}

.popup-box button {
    margin-top: 20px;
    padding: 10px 25px;
    font-size: 16px;
    cursor: pointer;
    background: #ac8f45;
    color: white;
    border: none;
    border-radius: 8px;
}
</style>
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

<!-- =====[ BALANCE CARD ]===== -->
<div class="balance-container">
    <div class="balance-card">
        <div class="balance-label">
            AVAILABLE BALANCE 
            <span class="eye-icon" id="eyeIcon" onclick="toggleBalance()">
                <img src="Images/Eye.png" alt="" width="20">
            </span>
        </div>
        <div class="balance-amount" id="balance">
            ₱ <?php echo number_format($balance, 2); ?>
        </div>
    </div>
</div>

<script>
let balanceVisible = true;
function toggleBalance() {
    const balanceElement = document.getElementById("balance");
    if (balanceVisible) {
        balanceElement.innerText = "●●●●●●●";
        balanceVisible = false;
    } else {
        balanceElement.innerText = "₱ <?php echo number_format($balance, 2); ?>";
        balanceVisible = true;
    }
}
</script>


<!-- =====[ ICON ROW ]===== -->
<div class="icon-row">
    <a class="icon-btn" onclick="goTo('Transfer.php')">
        <img src="Images/Transfer.png"><p>Transfer</p>
    </a>
    <a class="icon-btn" onclick="goTo('bills.html')">
        <img src="Images/Bill.png"><p>Bills</p>
    </a>
    <a class="icon-btn" onclick="goTo('loan.html')">
        <img src="Images/Loan.png"><p>Loan</p>
    </a>
    <a class="icon-btn" onclick="openDeposit()">
        <img src="Images/Safe_In.png"><p>Deposit</p>
    </a>
    <a class="icon-btn" onclick="goTo('withdraw.html')">
        <img src="Images/Safe_Out.png"><p>Withdrawal</p>
    </a>
    <a class="icon-btn" onclick="goTo('finance.html')">
        <img src="Images/Finance.png"><p>Finance</p>
    </a>
</div>

<!-- ===== DEPOSIT POPUP ===== -->
<div class="popup-bg" id="depositPopup">
    <div class="popup-box">
        <h3>Enter Deposit Amount</h3>
        <input type="number" id="depositAmount" placeholder="₱ 0.00">
        <br>
        <button onclick="addDeposit()">Submit</button>
        <button onclick="closePopup()" style="background:#555;">Cancel</button>
    </div>
</div>

<script src="Dashboard.js"></script>

<!-- prevent back button after logout -->


<script>
window.onload = function() {
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        // If somehow the user goes back, force redirect
        window.location.href = 'Login.php';
    };
};
</script>

</body>
</html>