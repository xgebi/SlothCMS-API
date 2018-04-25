<template>
  <div class="login-screen">
    <div class="login-dialog">
      <label for="username">Username:</label>
      <input id="username" type="text" />
      <label for="password">Password:</label>
      <input id="password" type="text" />
      <a>Reset password</a>
      <button>Log in</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoginScreen',
}
</script>

<style>
.login-screen {
  background: purple;
  display: grid;
  grid-template-rows: 1fr 1fr 1fr;
  grid-template-columns: 1fr 1fr 1fr;
  height: 100vh;
  width: 100vw;
}

.login-screen .login-dialog {
  grid-row: 2 / 3;
  grid-column: 2 / 3;
  display: grid;
  grid-template-columns: 1fr 1fr;
  padding: 1rem;
  background: white;
}
</style>
