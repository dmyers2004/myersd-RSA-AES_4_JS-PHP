<form id="login-form" class="form-inline" method="post" action="/<?=$uri ?>">
  <input type="text" name="email" class="input-large" placeholder="Email" id="email" value="joe@coffee.com">
  <input type="password" name="password" class="input-large" placeholder="Password" id="password" value="password123">
  <input type="hidden" name="onetime" value="onetime123">
  <button id="login-submit" type="button" class="btn">Sign in</button>
</form>
<p><a href="/form">Try to access protected page</a></p>
<p><?=$flashmsg ?></p>