<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include "../../inc_header.php"; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Registration successful. Please wait for administrator approval.
    </div>
    <a href="../../index.php" class="btn btn-primary">Go Back</a>
<?php else: ?>

    <h2>Register</h2>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars(urldecode($_GET['message'])); ?>
        </div>
    <?php endif; ?>

    <form action="register_process.php" method="post">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Register</button>
    </form>

<?php endif; ?>

<?php include "../../inc_footer.php"; ?>
