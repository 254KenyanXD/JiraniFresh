<?php
include "includes/header.php";
?>

<h2>Create Account</h2>

<form action="register_process.php" method="POST" class="order-form">
    <label>Full Name</label>
    <input type="text" name="fullname" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Phone Number</label>
    <input type="text" name="phone" required>

    <label>Address</label>
    <textarea name="address" required></textarea>

    <label>Account Type</label>
    <select name="role">
        <option value="customer">Customer</option>
        <option value="farmer">Farmer</option>
        <option value="rider">Rider</option>
    </select>

    <button type="submit" class="btn">Register</button>
</form>

<?php include "includes/footer.php"; ?>