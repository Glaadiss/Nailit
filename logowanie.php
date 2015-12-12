

<form class="form-horizontal" method="POST" action="login.php">
  <div class="form-group">
   <label for="inputEmail3" class="col-sm-3 control-label">Login</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="Login"
      name="login" maxlength="32">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Hasło</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Hasło"
      name="haslo" maxlength="32">
    </div>
  </div>
  <div class="form-group">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Pamiętaj mnie!
        </label>
    </div>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-default">Zaloguj</button>
  </div>
</form>