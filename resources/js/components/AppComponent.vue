<template>
  <div class="row mt-40">
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
          :to="{ name: 'logout'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            v-if="authenticated"
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="logout">Logout</a>
          </li>
        </router-link>

        <router-link
          :to="{ name: 'login'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            v-if="!authenticated"
            :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"
          >
            <a :href="href" @click="navigate">Login</a>
          </li>
        </router-link>
        <router-link
          :to="{ name: 'registration'}"
          v-slot="{ href, route, navigate, isActive, isExactActive }"
        >
          <li
            v-if="!authenticated"
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
      auth.logout();
    },
  },
};
</script>
