<template>
  <div>
    <h1>Login</h1>

    <div class="form-group">
      <label for="username">Phone</label>

      <input class="form-control" type="text" name="username" v-model="username" />
    </div>

    <div class="form-group">
      <label for="password">Password</label>

      <input class="form-control" type="password" name="password" v-model="password" />
    </div>

    <button @click="login">Login</button>
  </div>
</template>
<script>
export default {
  name: "login-component",
  data: () => {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    login() {
      let data = {
        phone: this.username,
        password: this.password,
      };

      axios
        .post("/api/login", data)
        .then(({ data }) => {
          auth.login(data.token, data.data, data.userInfo);
          this.$router.push({ name: "search" });
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    },
  },
};
</script>