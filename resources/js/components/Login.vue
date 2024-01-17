<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <label>Email:</label>
      <input v-model="email" type="email" required />
      <br />
      <label>Password:</label>
      <input v-model="password" type="password" required />
      <br />
      <button type="submit">Login</button>
    </form>
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
          console.log(userAuthenticate.data.message)
      } else {
        localStorage.setItem('token', userAuthenticate.data.token);
        this.$router.push('/');
      }
    }
  },
};
</script>