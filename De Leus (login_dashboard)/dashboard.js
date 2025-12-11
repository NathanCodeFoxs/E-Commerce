/* ===== SIDEBAR FUNCTIONS ===== */
function openSidebar() {
    document.getElementById("sidebarBg").style.width = "100%";
    document.getElementById("sidebar").style.left = "0";
}

function closeSidebar() {
    document.getElementById("sidebarBg").style.width = "0";
    document.getElementById("sidebar").style.left = "-280px";
}

/* ===== PAGE NAVIGATION ===== */
function goTo(page) {
    window.location.href = page;
}

/* ===== POPUP ===== */
function openDeposit() {
    closeSidebar();
    document.getElementById("depositPopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("depositPopup").style.display = "none";
}

/* ===== BALANCE LOGIC ===== */
let balance = 1532.43;

function addDeposit() {
    let amount = parseFloat(document.getElementById("depositAmount").value);
    if (!isNaN(amount) && amount > 0) {
        balance += amount;
        document.getElementById("balance").innerText = "₱ " + balance.toFixed(2);
    }
    closePopup();
}

/* ===== SHOW / HIDE BALANCE ===== */
let balanceVisible = true;
let actualBalance = 1532.43; // starting balance

function toggleBalance() {
    const balanceElement = document.getElementById("balance");
    const eyeIcon = document.getElementById("eyeIcon");

    if (balanceVisible) {
        // Hide balance
        balanceElement.innerText = "●●●●●●●";
        
        balanceVisible = false;
    } else {
        // Show balance
        balanceElement.innerText = "₱ " + actualBalance.toFixed(2);
        
        balanceVisible = true;
    }
}

/* UPDATE DEPOSIT FUNCTION */
function addDeposit() {
    let amount = parseFloat(document.getElementById("depositAmount").value);
    if (!isNaN(amount) && amount > 0) {
        actualBalance += amount;

        // Only update visible balance if it is showing
        if (balanceVisible) {
            document.getElementById("balance").innerText = "₱ " + actualBalance.toFixed(2);
        }
    }

    closePopup();
}