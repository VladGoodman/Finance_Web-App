<template>
  <div class="form">
    <div class="form-title">
      registration
    </div>
    <div class="form-body">
      <form v-on:submit.prevent="register">
        <div class="form-body__input">
          <label for="register-name">Username</label>
          <input v-model="form.username" type="text" id="register-name" >
        </div>
        <div class="form-body__input">
          <label for="register-email">Email</label>
          <input v-model="form.email" type="email" id="register-email" >
        </div>
        <div class="form-body__input">
          <label for="register-password">Password</label>
          <input v-model="form.password" type="password" id="register-password" >
        </div>
        <div class="form-body__input">
          <label for="register-repeat_password">Repeat Password</label>
          <input v-model="form.repeat_password" type="password" id="register-repeat_password" >
        </div>
        <div class="form-body__danger">
          {{errors}}
        </div>
        <div class="form-body__success">
          {{ success }}
        </div>
        <button class="form-body__btn">
          Register
        </button>
      </form>
    </div>
    <div class="form-social">
      <div class="form-social__item">
        <img src="" alt="">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      form: {
        username: '',
        email: '',
        password: '',
        repeat_password: '',
      },
      errors: {},
      success: null
    }
  },
  computed:{
    checkErrors(){

    }
  },
  methods: {
    checkRepeatPassword(){
      return this.form.password === this.form.repeat_password;
    },
    register () {
      if (this.checkRepeatPassword()){
        this.errors = null;
        this.$store.dispatch('register', {
          name: this.form.username,
          email: this.form.email,
          password: this.form.password
        })
          .then(res=>{
            console.log(res)
            this.$router.push({name: 'profileIndex'});
          })
          .catch(err=> {
            console.log(err.response.data.errors);
            this.errors = err.response.data.errors
          });
      }else{
        this.errors = 'Password mismatch'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.form {
  color: white;
  background-color: #40467C;
  border-radius: 40px;
  padding: 64px 44px;
  width: 520px;

  &-title {
    text-transform: uppercase;
    text-align: center;
    font-size: 36px;
    margin-bottom: 45px;
  }
  &-body {
    &__input {
      margin: 15px 0;
      font-size: 18px;
      display: flex;
      flex-direction: column;
      label {
        display: block;
        font-size: 18px;
      }
      input {
        margin: 0;
        display: block;
        border: 3px white solid;
        border-radius: 6px;
        background: none;
        padding: 23px 17px;
      }
    }
    &__btn{
      width: 100%;
      padding: 16px 0;
      background: #23263E;
      font-size: 30px;
      font-weight: normal;
      color: white;
      border: none;
      margin-top: 26px;
      cursor: pointer;
    }
  }
  &-or{
    text-transform: uppercase;
    font-size: 50px;
    font-weight: bold;
  }
}
</style>
