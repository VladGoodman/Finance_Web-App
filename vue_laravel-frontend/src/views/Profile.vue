<template>
  <div class="profile-container">
    <div class="header">
      <div class="header__logo">
        Finans
      </div>
      <div class="header__right">
        <div class="header__right-score">
          Состояние счета:
          <span id="right-score">
            {{score}} ₽
          </span>
        </div>
        <div class="header__right-username">
          {{username}}
        </div>
        <div class="header__right-logout">
          <b-button type="is-danger" outlined @click="logout">
            Выход
          </b-button>
        </div>
      </div>
    </div>
    <div class="menu">
      <profile-menu></profile-menu>
    </div>
    <div class="content">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
import ProfileMenu from '../components/ProfileMenu/ProfileMenu'
export default {
  components:{
    ProfileMenu
  },
  data() {
    return{
      username: '',
      score: 0
    }
  },
  created(){
    this.username = this.$store.getters.username
    this.score = this.$store.getters.user_sum_change
  },
  methods:{
    async logout() {
      try {
        await this.$store.dispatch('logout')
            .then(this.$router.push('/'));
      } catch (error) {
        this.error = error;
      }
    },
  }
}
</script>

<style>
  .header{
    background: #23263E;
    grid-area: header;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
    color: #c9c9c9;
    font-size: 26px;
  }
  .profile-container{
    display: grid;
    grid-template-areas: "header header"
                       "sidebar content";
    width: 100%;
    grid-template-columns: 1fr 3fr;
    grid-template-rows: 50px minmax(1000px, max-content);
  }
  .menu{
    background-color: #40467C;
    grid-area: sidebar;
  }
  .content{
    background-color: #e8e8e8;
    grid-area: content;
  }
  .header__right{
    display: flex;
  }
  .header__logo{
    font-weight: bold;
    color: white;
  }
  .header__right > *{
    padding: 0 10px;
  }
  #right-score{
    color: #F86B4F;
  }
  .header__right-username{
    text-decoration: underline;
    text-transform: uppercase;
  }
</style>
