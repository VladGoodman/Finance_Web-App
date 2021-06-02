<template>
  <div class="item-container" :class="[item.change_id === 1 ? 'item-delete': 'item-add' ]">
    <div>
      <div class="item-name">
        {{ item.type_changes }}
      </div>
      <div class="item-score">
        <span>{{ item.date }}</span>
      </div>
    </div>
    <div class="item-right">
      <span class="item-right__score">
        <span class="right__score-plus" v-if="item.change_id === 1">-</span>
        <span class="right__score-plus" v-if="item.change_id === 2">+</span>
        {{ item.quantity }} {{ item.currency_type }}
      </span>
      <button class="delete-btn" @click="deleteChangeAccount(item.id)" >
        <img class="list-icon" src="../../assets/icons/clear.svg" alt="">
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['item'],
  methods:{
    deleteChangeAccount(id){
      console.log('ID in component: ' + id)
      this.$store.dispatch('getAccountInfo')
      this.$store.dispatch('deleteChangeAccount', id)
        .then(res => {
          this.$emit('update')
        })
    }
  }
}
</script>

<style lang="scss" scoped>
  .item-add{
    border-left: 5px solid #3fc13b;
    color: #3fc13b;
  }
  .item-delete{
    border-left: 5px solid #d02020;
    color: #d02020;
  }
  .item-container{
    margin: 20px 0;
    padding: 5px 10px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #4E4E50;
    .item-icon{
      margin-left: 10px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #42b983;
    }
    .item-name{
      font-size: 25px;
      margin-left: 10px;
    }
    .item-score{
      margin-left: 10px;
      color: #4E4E50;
    }
  }
  .list-icon{
    width: 20px;
  }
  .delete-btn{
    background: none;
    border: none;
    cursor: pointer;
  }
  .item-right{
    display: flex;
    flex-direction: row;
    align-items: baseline;
  }
  .item-right__score{
    margin-right: 10px;
    font-size: 30px;
  }
  .right__score-plus{
    font-weight: bold;
    font-size: 40px;
  }
  .item-container:hover{
    background-color: #b3e8ff;
  }
</style>
