<template>
  <div class="menu">
    <div class="menu-container">
      <ul class="menu-items">
        <li class="menu-items__item">
          <router-link to="/profile">
            <div class="menu-items__item-text">
              Измнения
            </div>
          </router-link>
        </li>
        <li class="menu-items__item">
          <router-link to="/profile/time">
            <div class="menu-items__item-text">
              Статистика
            </div>
          </router-link>
        </li>
        <li class="menu-items__item">
          <router-link to="/profile/converter">
            <div class="menu-items__item-text">
              Конвертация
            </div>
          </router-link>
        </li>
        <li class="menu-items__item">
          <router-link to="/profile/groups">
            <div class="menu-items__item-text">
              Группы
            </div>
          </router-link>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
import ProfileMenuScore from "./ProfileMenuScore";

export default {
  name: 'ProfileMenu',
  props: ['score'],
  components: {ProfileMenuScore},
  comments: ProfileMenuScore,
  data() {
    return{
      username: ''
    }
  },
  methods: {
    async logout() {
      try {
        await this.$store.dispatch('logout')
            .then(this.$router.push('/'));
      } catch (error) {
        this.error = error;
      }
    },
  },
  created(){
    this.username = this.$store.getters.username
  }
}
</script>

<style lang="scss" scoped>
  .menu{
    margin-top: 30px;
  }
  .menu-items__item{
    width: 100%;
  }
  .menu-items__item{
   border-bottom: 5px solid #23263E;
  }
  .menu-items__item:hover{
    background: #282d57;
  }
  .menu-items__item-text{
    padding: 10px 30px;
    font-size: 30px;
    color: #c9c9c9;
  }
</style>
