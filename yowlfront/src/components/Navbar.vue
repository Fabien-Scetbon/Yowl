<template>
  <nav id="navTop" class="sticky-top">
    <div
      id="container"
      class="d-flex flex-row justify-content-between align-items-center"
    >
      <router-link to="/">
        <img class="ml-3" src="../assets/logo.png" alt="Yowl !" title="Yowl !" />
      </router-link>

      <div>
        <div class="input-group">
          <i class="input-group-text fas fa-search"></i>
          <input type="text" placeholder="Search for anything" />
        </div>
      </div>

      <ul class="nav d-flex flex-row">
        <li v-if="showAdminBoard" class="nav-item">
          <router-link to="/dashboard">DashBoard</router-link>
        </li>
        <li v-if="currentUser" class="nav-item">
          <router-link to="/profile">{{ currentUser.login }}</router-link>
        </li>
        <li v-if="currentUser" class="nav-item" @click.prevent="logOut">
          <a href="#">Logout</a>
        </li>
        <li v-if="!currentUser" class="nav-item">
          <router-link to="/register">Sign Up</router-link>
        </li>
        <li v-if="!currentUser" class="nav-item">
          <router-link to="/login">Login</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
    showAdminBoard() {
      if (this.currentUser && this.currentUser["status"]) {
        return this.currentUser["status"].includes("1");
      }
      return false;
    },
  },
  methods: {
    logOut() {
      this.$store.dispatch("auth/logout");
      this.$router.push("/");
    },
  },
};
</script>

<style>
#navTop {
  background-color: #aa4444;
  height: 137px;
  -webkit-box-shadow: 0px 7px 23px -6px #000000;
  box-shadow: 0px 7px 23px -6px #000000;
}
#container {
  height: 100%;
}
.input-group-text {
  font-weight: 800 !important;
}
.input-group input {
  padding-left: 1rem !important;
}
.nav-item {
  color: #fff;
  margin-right: 0.5rem;
}
.nav-item a:hover {
  color: #f59e0b;
}
.nav-item:not(:last-child):after {
  margin-left: 0.5rem;
  content: "|";
}
</style>