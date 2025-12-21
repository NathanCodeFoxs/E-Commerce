<?php
require_once __DIR__ . "/PHP/auth.php";
require_once __DIR__ . "/PHP/db.php";

$user_id = $_SESSION['user_id'];

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deposit_amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

    if ($deposit_amount <= 0) {
        $_SESSION['deposit_error'] = "Enter a valid amount!";
    } else {
        // Update balance
        $stmt = $conn->prepare("UPDATE balances SET balance = balance + ? WHERE user_id=?");
        $stmt->bind_param("di", $deposit_amount, $user_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['deposit_success'] = "Successfully deposited ₱" . number_format($deposit_amount, 2);
    }
    header("Location: Deposit.php");
    exit();
}

// Fetch current balance for display
$stmt = $conn->prepare("SELECT balance FROM balances WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deposit</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: "Georgia", "Times New Roman", serif; }

body {
    font-family: "Georgia", "Times New Roman", serif;
    min-height: 100vh;
    background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
    color: white;
}

.header {
    width: 100%;
    height: 100px;
    background: #0b2931;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav-head {
    width: 100%;
    height: 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: transparent;
}

.header-title {
    font-size: 40px;
    font-weight: 600;
    color: #FFFFFF;
}

.card {
    width: 420px;
    margin: 60px auto 0;
    padding: 50px 25px;
    background: rgba(0, 0, 0, 0.32);
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.35);
    border-radius: 6px;
}

.balance-box {
    background: #AC8F45; /* Gold oval */
    padding: 12px 18px;
    border-radius: 16px;
    margin-bottom: 25px;
    text-align: center;
}

.balance-label {
    font-size: 16px;
    letter-spacing: 1.5px;
    margin-bottom: 4px;
}

.balance-value {
    font-size: 28px;
    line-height: 1.2;
}

.input-wrap {
    width: 80%;
    margin: 0 auto 30px;
    text-align: left;
}

.label {
    font-size: 16px;
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
    padding: 13px 0;
    background: #AC8F45;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: bold;
    color: #FFFFFF;
    cursor: pointer;
}

/* SIDEBAR */
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
    font-size: 18px;
    text-decoration: none;
    cursor: pointer;
}

.sidebar img {
    margin-right: 15px;
    vertical-align: middle;
}

.sidebar a:hover {
    background: #10303a;
}

.menu-icon { font-size: 32px; cursor: pointer; color: white; margin-left: 20px; }
.bell-icon { margin-right: 20px; }

</style>
</head>
<body>

<!-- SIDEBAR + NAVBAR -->
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

<div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
    <span class="header-title">Deposit</span>
    <span class="bell-icon"><img src="Images/Notification.png" alt="notification" width="30"></span>
</div>
</div>

<!-- DEPOSIT CARD -->
<div class="card">
<?php
if (!empty($_SESSION['deposit_error'])) {
    echo "<p style='color:red; text-align:center;'>".$_SESSION['deposit_error']."</p>";
    unset($_SESSION['deposit_error']);
}
if (!empty($_SESSION['deposit_success'])) {
    echo "<p style='color:green; text-align:center;'>".$_SESSION['deposit_success']."</p>";
    unset($_SESSION['deposit_success']);
}
?>

<div class="balance-box">
    <div class="balance-label">AVAILABLE BALANCE</div>
    <div class="balance-value">₱ <?php echo number_format($balance,2); ?></div>
</div>

<form method="POST">
    <div class="input-wrap">
        <div class="label">Deposit Amount</div>
        <input type="number" name="amount" placeholder="Enter amount" step="0.01" min="0.01" required>
    </div>
    <button type="submit">Confirm</button>
</form>
</div>

<script>
function openSidebar(){ 
    document.getElementById('sidebar').style.left='0'; 
    document.getElementById('sidebarBg').style.width='100%'; 
}
function closeSidebar(){ 
    document.getElementById('sidebar').style.left='-280px'; 
    document.getElementById('sidebarBg').style.width='0'; 
}
function goTo(url){ 
    window.location.href=url; 
}
</script>

</body>
</html>