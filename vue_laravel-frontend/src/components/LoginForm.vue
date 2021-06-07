<template>
  <div class="form">
    <div class="form-title">
      Авторизация
    </div>
    <div class="form-body">
      <form v-on:submit.prevent="login">
        <div class="form-body__input">
          <label for="login-email">Email</label>
          <input v-model="form.email"  type="email" id="login-email" name="login-email" required>
        </div>
        <div class="form-body__input">
          <label for="login-password">Пароль</label>
          <input v-model="form.password" type="password" id="login-password" name="login-password" required>
        </div>
        <div class="form-body__err">
          {{ errors }}
        </div>
        <button class="form-body__btn">
          Войти
        </button>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  name: 'LoginForm',
  data () {
    return {
      form: {
        email: '',
        password: ''
      },
      errors: ' '
    }
  },
  computed:{
    checkErrors(){

    }
  },
  methods: {
    login () {
      this.errors = null;
        this.$store.dispatch('login', this.form)
          .then(res=>{
            console.log(res);
            this.$router.push({name: 'profileIndex'});
          })
          .catch(err=> {
            if (err.data.status === false){
              this.errors = 'Неправильный логин или пароль'
            }
          });
    },

  }
}
</script>

<style lang="scss" scoped>
  .form {
    color: white;
    background-color: #40467C;
    border-radius: 40px;
    padding: 30px 44px;
    width: 520px;

    &-title {
      text-transform: uppercase;
      text-align: center;
      font-size: 36px;
      margin-bottom: 45px;
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
