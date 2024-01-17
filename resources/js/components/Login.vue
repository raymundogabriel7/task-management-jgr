<template>
  <div class="container mt-5">
    <div class="row mt-3">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" v-model="email" type="email" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input class="form-control" v-model="password" type="password" required />
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
      </div>
  </div>
</template>

<script>

import authUser from '../api/auth';
import constants from '../utilities/constants';
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      const userAuthenticate = await authUser({
        email: this.email,
        password: this.password,
      });
      if(userAuthenticate.status === constants.HTTP_CODE_UNAUTHORIZED) {
          this.$swal(userAuthenticate.data.message)
      } else {
        localStorage.setItem('token', userAuthenticate.data.token);
        window.location.href = import.meta.env.VITE_APP_BASE_URL + `tasks`
      }
    }
  },
};
</script>