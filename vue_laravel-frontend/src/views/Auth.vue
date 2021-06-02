<template>
  <div class="container">
    <div class="auth-block">
      <login-form v-if="!loggedIn"/>
      <register-form v-if="!loggedIn"/>
    </div>
    <router-link to="/logout" v-if="loggedIn">Logout</router-link>
  </div>
</template>

<script>
import LoginForm from '../components/LoginForm'
import RegisterForm from '../components/RegisterForm'
export default {
  name: 'Auth',
  components: { LoginForm,  RegisterForm},
  computed:{
    loggedIn(){
      return this.$store.getters.loggedIn
    }
  }
}
</script>


