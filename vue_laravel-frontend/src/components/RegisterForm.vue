<template>
  <div class="form">
    <div class="form-title">
      Регистрация
    </div>
    <div class="form-body">
      <form v-on:submit.prevent="register">
        <div class="form-body__input">
          <label for="register-name">Имя пользователя</label>
          <input v-model="form.username" type="text" id="register-name" required>
        </div>
        <div class="form-body__input">
          <label for="register-email">Email</label>
          <input v-model="form.email" type="email" id="register-email" required>
        </div>
        <div class="form-body__input">
          <label for="register-password">Пароль</label>
          <input v-model="form.password" type="password" id="register-password" required>
        </div>
        <div class="form-body__input">
          <label for="register-repeat_password">Повторите пароль</label>
          <input v-model="form.repeat_password" type="password" id="register-repeat_password" required>
        </div>
        <div class="form-body__errors">
          {{errors}}
        </div>
        <button class="form-body__btn">
          Зарегистрироваться
        </button>
      </form>
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
      errors: '',
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
            this.$router.push({name: "profileIndex"})
          })
          .catch(err=> {
            if(err.data.errors.email[0]){
              if(err.data.errors.email[0] === "The email has already been taken."){
                this.errors = 'Эта почта уже занята'
              }
            }
          });
      }else{
        this.errors = 'Пароли не совпадают'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.form-body__input{
  height: 50px;
}
.form {
  color: white;
  background-color: #40467C;
  border-radius: 40px;
  padding: 30px 44px;
  width: 450px;

  &-title {
    text-transform: uppercase;
    text-align: center;
    font-size: 36px;
    margin-bottom: 20px;
  }
  &-body {
    &__input {
      font-size: 18px;
      display: flex;
      flex-direction: column;
      margin: 28px 0;
      label {
        display: block;
        font-size: 16px;
      }
      input {
        margin: 0;
        color: white;
        display: block;
        border: 3px white solid;
        border-radius: 6px;
        background: none;
        padding: 10px 17px;
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
