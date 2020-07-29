<template>
  <div>
    <h1>Login</h1>

    <div class="form-group">
      <label for="username">Phone</label>

      <input class="form-control" type="text" name="username" v-model="username" />
    </div>

    <div class="form-group">
      <label for="password">Password</label>

      <input
        class="form-control"
        type="password"
        name="password"
        v-model="password"
        @keyup.enter="login"
      />
    </div>

    <button @click="login" class="btn btn-primary" :disabled="disabled == 1">Login</button>
  </div>
</template>
<script>
export default {
  name: "login-component",
  data: () => {
    return {
      username: "",
      password: "",
      disabled: 0,
    };
  },
  methods: {
    login(event) {
      this.disabled = 1;
      let data = {
        phone: this.username,
        password: this.password,
      };

      api.call("post", "api/login", data).then(({ data }) => {
        auth.login(data.token, data.data, data.userInfo);
        this.$router.push({ name: "search" });
      });

      this.disabled = 0;
    },
  },
};
</script>