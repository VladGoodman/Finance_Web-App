<template>
  <div class="container">
    <div class="group__name">
      <router-link :to="{ name: 'group', params: {id: group.group_id}}">
        {{group.group_name}}
      </router-link>
    </div>
    <div class="group__btn">
      <b-button class="group__btn-item" type="is-danger"  outlined @click="leaveGroup(group.participations_id)">Покинуть группу</b-button>
    </div>
  </div>
</template>

<script>
export default {
  name: "GroupItem",
  props:['group'],
  methods:{
    leaveGroup(id){
      console.log(id)
      this.$store.dispatch('leaveGroup', id)
          .then(res => {
            this.$emit('update')
            console.log(res)
          })
    },
  }
}
</script>

<style scoped>
  .container{
    border: 1px solid #242B35;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .group__name{
    font-size: 30px;
    font-weight: bold;
  }
  .group__name > *{
    color: #242B35;
  }
</style>
