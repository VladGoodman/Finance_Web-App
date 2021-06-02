<template>
  <div class="list-container">
    <b-loading v-model="isLoading" :can-cancel="true" :is-full-page="false"></b-loading>
    <div class="list__left">
      <div class="list__left-title">
        <div class="left-title__text">
          Изменения счета
        </div>
      </div>
      <div class="list__left-items">
        <list-changes-item v-on:update="getAccountData" v-for="l in list" :item="l">
        </list-changes-item>
      </div>
    </div>
    <div class="list__right">
      <input-add-change class="list-form" v-on:update="getAccountData"></input-add-change>
    </div>
  </div>
</template>

<script>
import ListChangesItem from './ListChangesItem'
import InputAddChange from './InputAddChange'
export default {

  components:{
    ListChangesItem,
    InputAddChange
  },
  data() {
    return {
      list: [],
      isLoading: true,
      score: 0
    }
  },
  methods:{
    sortAccountData(mass){
      return mass.sort((a,b) =>{
        return Date.parse(b.date) - Date.parse(a.date)
      })
    },

    getAccountData(){
      this.$store.dispatch('getAccountChanges')
        .then(res => {
          console.log(res.data)
          this.list = this.sortAccountData(res.data)
          this.isLoading = false
        })
        .catch(err => console.log(err))
      console.log(this.list)
    },

  },
  created(){
    this.getAccountData()
  },
}
</script>

<style scoped>
  .list-container{
    padding: 30px 30px;
    display: grid;
    grid-template-columns: 3fr 1fr;
    grid-template-rows: 1fr;
    grid-gap: 10px;
  }
  .list__left{
    background-color: #fff;
  }
  .list-form{
    margin: 10px 0 40px 0;
  }
  .list__left-title{
    background-color: #A8CCEE;
    padding: 30px 30px;
    color: #3F3F3F;
    border-bottom: 4px solid #6E91B2;
    font-weight: normal;
    font-size: 24px;


    display: flex;
    align-items: center;
  }
  .list__left-items{
    margin-top: 50px;
  }
</style>
