<template>
  <form v-on:submit.prevent="createGroup">
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Создание группы</p>
      </header>
      <section class="modal-card-body">
        <b-field label="Название">
          <b-input
              type="text"
              v-model="name"
              placeholder="Введите название группы"
              required>
          </b-input>
        </b-field>
        <button class="create__button">
          Создать
        </button>
      </section>
    </div>
  </form>
</template>

<script>
export default {
  name: "ModalCreate",
  props: ['canCancel'],
  data(){
    return{
      name: ""
    }
  },
  methods: {
    async createGroup(){
      await this.$store.dispatch('createGroup',this.name)
          .then(res => {
            this.$router.push({name: 'group', params:{id: res.data.info.group_id}})
          })
    }
  }
}
</script>

<style scoped>
  .modal-card{
    width: 300px;
  }
  .create__button{
    padding: 10px 0;
    width: 100%;
    background-color: #4E4E50;
    color: white;
    text-align: center;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
  }
</style>
