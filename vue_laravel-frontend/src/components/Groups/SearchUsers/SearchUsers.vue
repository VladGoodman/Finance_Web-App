<template>
  <div class="search-container">
    <div class="search__title">
      Создание приглашения в группу
    </div>
    <div class="search__content">
      <div class="search__content-form">
        <form v-on:submit.prevent="searchUsers">
          <b-field>
            <b-input placeholder="Введите имя пользователя..." expanded v-model="username"></b-input>
            <p class="control">
              <b-button @click="searchUsers" label="Найти" type="is-primary" />
            </p>
          </b-field>
        </form>
      </div>
      <div class="search__content-list">
        <div class="content-list__title">
          Результаты поиска:
        </div>
        <div class="content-list__items">
          <div v-if="list.length !== 0" class="search__result">
            <div class="list__item" v-for="item in list">
              <div class="list__item-name">
                {{ item.name }}
              </div>
              <div class="list__item-btn">
                <b-button type="is-success is-light" @click="createInvite(item.id)">
                  Отправить приглашение
                </b-button>
              </div>
            </div>
          </div>
          <div v-if="list.length === 0" class="search__err">
            Список пуст
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "SearchUsers",
  data(){
    return{
      username: '',
      list: []
    }
  },
  methods:{
    searchUsers(){
      this.$store.dispatch('searchUsers', this.username)
        .then(res => {
          this.list = res.data.users;
        })
      .catch(err => {
        this.list = []
      })
    },
    async createInvite(id){
      console.log(id)
      console.log(this.$route.params.id)

      this.$store.dispatch('createInvite', {
        user_id: id,
        group_id: this.$route.params.id
        }).then(res => {
            this.$buefy.notification.open({
              message: 'Приглашение отправлено!',
              type: 'is-success'
            })
        })
    }
  },
  mounted() {
    document.title = "Поиск игроков | Finans"
  },
}
</script>

<style scoped>
  .search-container{
    padding: 30px;
  }
  .search__title{
    background-color: #A8CCEE;
    padding: 30px 30px;
    color: #3F3F3F;
    border-bottom: 4px solid #6E91B2;
    font-weight: normal;
    font-size: 24px;
  }
  .search__content{
    background-color: #fff;
    padding: 10px 30px;
  }
  .search__content-form{
    padding: 20px 0;
    border-bottom: 2px solid #4E4E50;
  }
  .content-list__title{
    margin: 20px 0;
  }
  .list__item{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #000;
    padding: 5px 10px ;
    margin: 10px 0;
  }
</style>
