<template>
  <div class="row mt-4">
    <div class="col-md-3">
      <ul>
        <router-link
          :to="{ name: 'search'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="navigate">Search</a>
          </li>
        </router-link>

        <router-link
          v-if="authenticated"
          :to="{ name: 'logout'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="!isLogout ? '#' : href" @click="logout">Logout</a>
          </li>
        </router-link>

        <router-link
          v-if="authenticated"
          :to="{ name: 'profile'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="navigate">Profile</a>
          </li>
        </router-link>

        <router-link
          v-if="!authenticated"
          :to="{ name: 'login'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="navigate">Login</a>
          </li>
        </router-link>
        <router-link
          v-if="!authenticated"
          :to="{ name: 'registration'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="navigate">Registration</a>
          </li>
        </router-link>
      </ul>
    </div>
    <div class="col-md-9">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      authenticated: auth.check(),
      isLogout: false,
    };
  },
  created() {
    this.authenticated = auth.check();
  },
  watch: {
    $route(to, from) {
      this.authenticated = auth.check();
    },
  },
  methods: {
    logout() {
      if (confirm("Are You Sure?")) {
        auth.logout();
        this.isLogout = true;
      }
    },
  },
};
</script>
<style scoped>
ul {
  list-style: none;
  background-color: grey;
  padding: 10px;
}
li {
  padding: 10px;
  border-bottom: 1px solid ghostwhite;
  font-size: 15px;
  font-weight: 700;
}
ul > li:last-child {
  border-bottom: 0px;
}
ul > li > a {
  color: black;
}
ul > li.router-link-exact-active > a {
  color: #e2cb2b;
}
</style>