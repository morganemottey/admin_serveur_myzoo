<?php ob_start(); ?>
<form method="POST" action="<?= URL ?>back/connexion">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Login</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-secondary">Valider</button>
</form>
<?php
$content = ob_get_clean();
$titre = "Login";
require_once "views/common/template.php";