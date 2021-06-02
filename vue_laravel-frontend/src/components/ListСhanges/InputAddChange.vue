<template>
  <div >
    <form class="input-form" v-on:submit.prevent="createAccountChange">
      <div class="input-form__title">
        Добавить
      </div>
      <div class="forms-changes">
        <b-field class="form-radios">
          <b-radio
              v-model="change_type"
              native-value=2
              name="name"
              type="is-success">
            {{ changes_info[1].name }}
          </b-radio>
          <b-radio
              v-model="change_type"
              native-value=1
              name="name"
              type="is-danger">
            {{ changes_info[0].name }}
          </b-radio>
        </b-field>
        <b-field class="forms-changes_score">
          <b-select  v-model="name_type" placeholder="Тип" required>
            <option v-for="n in names_info" :value="n.id">{{n.name}}</option>
          </b-select>
        </b-field>
        <b-field class="forms-changes_input">
          <b-input min="0" type="number" v-model="change_quantity" placeholder="Колличество">
          </b-input>
        </b-field>
        <div class="buttons">
          <b-button class="button" @click="createAccountChange" type="is-success" outlined>+</b-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'InputAddChange',
  data() {
    return{
      names_info: [],
      changes_info: [
        {name: 'Затрата', type: 1},
        {name: 'Пополнение', type: 2}
      ],
      name_type: 0,
      change_type: 2,
      change_quantity: 0,
    }
  },
  methods:{
    async createAccountChange(){
      await this.$store.dispatch('createUserChange',{
        change_id: this.change_type,
        currency_id: 4,
        name_id: this.name_type,
        quantity: this.change_quantity
      })
        .then(res => {
          this.$emit('update')
          this.$store.dispatch('getAccountInfo')
        })
        .catch(err => console.log(err))
      this.change_quantity = 0
    }
  },
  created () {
    this.names_info = this.$store.getters.names;
    let keys = Object.keys(this.names_info);
    this.name_type = this.names_info[keys[0]].id
  }
}
</script>

<style scoped>
.input-form{
  background-color: #ffffff;
  padding: 18px;
}
  .input-form__title{
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 30px;
  }
  .buttons > button{
    width: 100%;
  }
</style>
