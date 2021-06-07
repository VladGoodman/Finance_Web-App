<template>
  <div class="auth">
    <div class="auth__header">
      <div class="auth__container">
        <div class="header__name">
          <router-link to="/">Finanser</router-link>
        </div>
      </div>
    </div>
    <div class="auth__container-content">
      <div class="auth__container">
        <div class="auth__container-forms">
          <login-form/>
          <register-form/>
        </div>
      </div>
    </div>
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
  },
  mounted() {
    document.title = "Авторизация | Finans"
  },
}
</script>

<style scoped="scoped">
  .auth{
    background-color: #EEEEEE;
    padding-bottom: 20px;
  }
  .auth__container{
    max-width: 1440px;
    margin: 0 auto;
    width: 100%;
  }
  .auth__container-content{
    padding-top: 20px;
  }
  .auth__header{
    display: flex;
    align-items: center;
    height: 40px;
    background-color: #242B35;
    padding-left: 127px;
    box-sizing: content-box;
  }
  .auth__container-forms{
    padding: 0 50px;
    display: flex;
    justify-content: space-between;
  }
  .header__name{
    width: 100%;
  }
  .header__name a{
    color: white;
    font-size: 24px;
  }
</style>


