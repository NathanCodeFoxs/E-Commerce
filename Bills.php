<?php
require_once __DIR__ . "/PHP/auth.php";
require_once __DIR__ . "/PHP/db.php";

// Get user ID
$user_id = $_SESSION['user_id'];

// Fetch payment history
$history_stmt = $conn->prepare("SELECT bill_name, amount, created_at FROM bills_payments WHERE user_id=? ORDER BY created_at DESC");
$history_stmt->bind_param("i", $user_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();
$payment_history = $history_result->fetch_all(MYSQLI_ASSOC);
$history_stmt->close();

// Collect paid bills
$paid_bills = [];
foreach($payment_history as $row) {
    $paid_bills[] = $row['bill_name'];
}

// Fetch user balance
$bal_stmt = $conn->prepare("SELECT balance FROM balances WHERE user_id=?");
$bal_stmt->bind_param("i", $user_id);
$bal_stmt->execute();
$bal_stmt->bind_result($balance);
$bal_stmt->fetch();
$bal_stmt->close();

$payment_message = '';
if(isset($_SESSION['payment_error'])) {
    $payment_message = $_SESSION['payment_error'];
    unset($_SESSION['payment_error']);
}
if(isset($_SESSION['payment_success'])) {
    $payment_message = $_SESSION['payment_success'];
    unset($_SESSION['payment_success']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bills</title>
<link rel="stylesheet" href="Bills.css">

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Georgia", "Times New Roman", serif;
  }

  body {
    background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
    color: #f7f5e9;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
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

  .header-title {
    font-size: 40px;
    font-family: "Georgia", "Times New Roman", serif;
    font-weight: 600;
    color: #FFFFFF;
  }

  main {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .section {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .inner-wrap {
    width: 100%;
    max-width: 900px;
  }

  .section-header {
    background: #0B3037;        /* same as table-wrapper */
    padding: 14px 20px;
    border-radius: 6px 6px 0 0; /* smooth top corners */
    font-size: 20px;
    font-weight: 600;
    color: #e7c97a;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    width: 100%;
    max-width: 900px;
    margin: 50px auto 0;       /* pull it close to table */
  }

  .table-wrapper {
    margin: 0 auto 30px;  /* remove extra top space */
    max-width: 900px;
    background: #0B3037;
    border-radius: 0 0 6px 6px; /* rounded bottom only */
    padding: 8px 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
  }

  /* scrollable area for table */
  .table-scroll {
    max-height: 170px;    /* adjust height as you like */
    overflow-y: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    color: #000000; 
  }

  th, td {
    padding: 8px 10px;
    text-align: left;
    border: 1px solid rgba(255,255,255,0.08);
    font-size: 13px;
  }

  th {
    background: #ffffff;
    color: #AC8F45;
    border: 1px solid #000000; 
    border-top: #000000;
    border-bottom: none;
    font-weight: 600;
    position: sticky;
    top: 0;               /* header stays visible while scrolling */
    z-index: 50;
    padding: 12px 10px;
    box-shadow: 0 2px #000000;
  }

  th::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1px;          /* thickness of border */
    background: #000;     /* border color */
    z-index: 100;         /* stays on top */
  }

  td {
    background: #ffffff; 
    color: #000000;
    border: 1px solid #000000;
    padding-top: 10px;
    padding-bottom: 10px;
  }

  .pay-options-header-wrap {
    margin: 60px 0 16px;
    display: flex;
    justify-content: center;
    margin-top: 100px;      
    margin-bottom: 50px;
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
  }

  .bill-card-top {
    background: #022933;
    border-radius: 12px 12px 0 0;
    padding: 18px 10px 22px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.7);
  }

  .bill-icon {
    font-size: 30px;
    margin-bottom: 10px;
  }

  .bill-label {
    font-size: 14px;
    margin-top: 4px;
  }

  .bill-amount {
    background: #f6e4b0;
    color: #4a3515;
    padding: 6px 4px;
    border-radius: 0 0 30px 30px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: inset 0 1px 3px rgba(255,255,255,0.4);
  }


  @media (max-width: 768px) {
    .title {
      font-size: 30px;
    }
    .pay-options-header {
      font-size: 22px;
      padding: 10px 40px;
    }
    .cards-row {
      gap: 24px;
    }
  }

  .bill-card {
    transition: 0.3s ease;
    cursor: pointer;
  }

  .bill-card:hover {
    transform: translateY(-8px) scale(1.05);
  }

  .bill-card-top {
    transition: 0.3s ease;
  }

  .bill-card:hover .bill-card-top {
    box-shadow: 0 6px 20px rgba(0,0,0,0.8);
    background: #033543; /* slightly brighter like dashboard hover */
  }

  .bill-card:hover .bill-amount {
    background: #ffe8a8;
    color: #3a2a10;
    box-shadow: inset 0 1px 3px rgba(255,255,255,0.5);
  }

  .bill-card.paid {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .bill-card.paid .bill-label::after {
    content: " (Paid)";
    font-size: 12px;
    color: #ffd700;
    font-weight: bold;
  }

</style>
</head>
<body>
<div class="header">
<div class="sidebar-bg" id="sidebarBg" onclick="closeSidebar()">
    <div class="sidebar" id="sidebar" onclick="event.stopPropagation()">
        <a onclick="goTo('Dashboard.php')"><img src="Images/home.png" alt="" width="20"> Dashboard</a>
        <a onclick="goTo('Transfer.php')"><img src="Images/Transfer.png" width="20"> Transfer</a>
        <a onclick="goTo('Bills.php')"><img src="Images/Bill.png" width="20"> Bills</a>
        <a onclick="goTo('Deposit.php')"><img src="Images/Safe_In.png" width="20"> Deposit</a>
        <a onclick="goTo('Withdrawal.php')"><img src="Images/Safe_Out.png" width="20"> Withdrawal</a>
        <a onclick="goTo('Finance.php')"><img src="Images/Finance.png" width="20"> Finance</a>
        <a onclick="goTo('settings.php')"><img src="Images/Setting.png" alt="" width="20"> Settings</a>
        <a onclick="goTo('PHP/logout.php')"><img src="Images/Logout.png" alt="" width="20"> Logout</a>
    </div>
</div>

<div class="nav-head">
    <div class="menu-icon" onclick="openSidebar()"><img src="Images/Sidebar.png" alt="" width="40"></div>
    <span class="header-title">Bills</span>
    <span class="bell-icon"><img src="Images/Notification.png" alt="notification" width="30"></span>
</div>
</div>

<?php if($payment_message): ?>
<script>
    alert("<?php echo addslashes($payment_message); ?>");
</script>
<?php endif; ?>

<main>
<section class="section">
<div class="inner-wrap">

    <div class="section-header">Payment History</div>
    <div class="table-wrapper">
        <div class="table-scroll">
        <table>
            <thead>
            <tr>
                <th>Payment</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($payment_history as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['bill_name']); ?></td>
                    <td>₱ <?php echo number_format($row['amount'],2); ?></td>
                    <td><?php echo date('m/d/Y', strtotime($row['created_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <div class="pay-options-header-wrap">
        <div class="pay-options-header">Payment Options</div>
    </div>

    <div class="cards-row">

    <?php
    // Define bills and amounts
    $bills = [
        ['name'=>'Water Bill','icon'=>'Images/Water.png','amount'=>150.65],
        ['name'=>'Electricity Bill','icon'=>'Images/Electricity.png','amount'=>1409.28],
        ['name'=>'Internet Bill','icon'=>'Images/Wifi.png','amount'=>6409.28],
    ];

    foreach($bills as $bill):
        $is_paid = in_array($bill['name'], $paid_bills);
    ?>
        <div class="bill-card <?php echo $is_paid ? 'paid' : ''; ?>">
            <div class="bill-card-top">
                <div class="bill-icon"><img src="<?php echo $bill['icon']; ?>"></div>
                <div class="bill-label"><?php echo $bill['name']; ?></div>
            </div>
            <div class="bill-amount">₱ <?php echo number_format($bill['amount'],2); ?></div>

            <!-- Hidden form for payment -->
            <form method="POST" action="PHP/process_bill_payment.php">
                <input type="hidden" name="bill_name" value="<?php echo $bill['name']; ?>">
                <input type="hidden" name="amount" value="<?php echo $bill['amount']; ?>">
                <button type="submit" style="display:none;" <?php echo $is_paid ? 'disabled' : ''; ?>></button>
            </form>
        </div>
    <?php endforeach; ?>

    </div>

    <p style="margin-top:20px; font-weight:bold; text-align:center;">Available Balance: ₱ <?php echo number_format($balance,2); ?></p>

</div>
</section>
</main>

<script>
document.querySelectorAll('.bill-card').forEach(card => {
    if(card.classList.contains('paid')) return; // skip already paid

    card.addEventListener('click', () => {
        const billName = card.querySelector('.bill-label').innerText;
        const amount = card.querySelector('input[name="amount"]').value;
        const confirmPay = confirm(`Are you sure you want to pay ${billName} of ₱${parseFloat(amount).toFixed(2)}?`);
        if(confirmPay){
            card.querySelector('button').click();
        }
    });
});

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