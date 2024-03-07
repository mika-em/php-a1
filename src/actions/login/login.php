<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . "/src/inc_header.php"); ?>

<div class="container">
  <h2>Login</h2>
  <form action="login_process.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>
</br>
</br>

</div>
</body>

</html>