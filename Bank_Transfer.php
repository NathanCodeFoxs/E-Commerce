<?php require_once __DIR__ . "/PHP/auth.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bank Transfer</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(90deg, #134E5E 39%, #0B3037 95%);
        color: #FFFFFF;
    }

    /* HEADER */
    .header {
        background-color: rgba(11, 48, 55, 0.8);
        padding: 20px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 34px;
        font-weight: bold;
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
        width: 50px;
        height: 50px;
    }

    .right-btn img {
        width: 30px;
        height: 30px;
    }

    .left-btn { left: 15px; }
    .right-btn { right: 15px; }

    /* FORM FRAME */
    .frame {
        width: 350px;
        margin: 60px auto;
        background-color: rgba(11, 48, 55, 0.8);
        padding: 30px;
        border-radius: 12px;
        text-align: left;
        font-size: 14px;
    }

    /* LABELS */
    .frame label {
        display: block;
        color: #FFFFFF;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .frame input,
    .frame select {
        width: 100%;
        padding: 12px;
        border: 1px solid #AC8F45;
        border-radius: 6px;
        margin-bottom: 18px;
        background-color: transparent;
        color: #FFFFFF;
        font-size: 14px;
        box-sizing: border-box;
        appearance: none;
        outline: none;
    }
    
    .frame select option {
    background-color: #0B3037;
    color: #FFFFFF;
    }

    /* Confirm Button */
    .confirm-btn {
        width: 100%;
        padding: 12px;
        background-color: #AC8F45;
        color: #FFFFFF;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .confirm-btn:hover {
        opacity: 0.9;
    }
</style>
</head>
<body>

<!-- HEADER WITH BUTTONS -->
<div class="header">

    <a href="Transfer.php" class="header-img-btn left-btn">
        <img src="Images/Bank_Transfer.png" alt="Left Button">
    </a>

    <span class="header-title">Bank Transfer</span>

    <a href="#" class="header-img-btn right-btn">
        <img src="Images/Notification.png" alt="Right Button">
    </a>

</div>

<!-- TRANSFER FORM FRAME -->
<div class="frame">
<form action="PHP/process_bank_transfer.php" method="POST">

    <label for="Bank">Bank:</label>
    <select name="bank_name" id="Bank" required>
        <option value="BDO">BDO</option>
        <option value="BPI">BPI</option>
        <option value="GCash">GCash</option>
    </select>

    <label>Account Number</label>
    <input type="text" name="to_account" required>

    <label>Account Name</label>
    <input type="text" name="to_name" required>

    <label>Money Amount</label>
    <input type="number" name="amount" min="1" required>

    <button type="submit" class="confirm-btn">Confirm</button>

</form>
</div>

</body>
</html>