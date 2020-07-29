<template>
  <div>
    <div class="card-header">User Registration</div>
    <form @submit.prevent="registration">
      <div class="form-group">
        <label for="name">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          placeholder="Enter your name please"
          required
          v-model="data.name"
        />
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          placeholder="Enter email"
          required
          v-model="data.email"
        />
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input
          type="phone"
          class="form-control"
          id="phone"
          placeholder="Enter phone number please"
          aria-describedby="phonelHelp"
          required
          v-model="data.phone"
        />
        <small
          id="phonelHelp"
          class="form-text text-muted"
        >Please add your country code please. Like Bangladesh +8801711111111. Phone number need for login.</small>
      </div>
      <div class="form-group">
        <label for="sex">Sex</label>
        <select class="form-control" id="sex" required v-model="data.sex">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          placeholder="Password"
          required
          v-model="data.password"
        />
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          type="password"
          class="form-control"
          id="password_confirmation"
          placeholder="Confirm Password"
          required
          v-model="data.confirmPassword"
        />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "reg-component",
  data: () => {
    return {
      data: {
        name: "",
        email: "",
        phone: "",
        sex: "",
        password: "",
        confirmPassword: "",
      },
    };
  },
  methods: {
    registration() {
      let data = {
        username: this.data.name,
        email: this.data.email,
        phone: this.data.phone,
        sex: this.data.sex,
        password: this.data.password,
        password_confirmation: this.data.password,
      };
      api.call("post", "api/create-user", data).then(({ data }) => {
        auth.login(data.token, data.data);
        this.$router.push({
          name: "userInfo",
          params: { user_id: data.data.id },
        });
      });
    },
  },
};
</script>