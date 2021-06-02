<template>
  <div>
    <b-loading v-model="isLoading" :can-cancel="true" :is-full-page="false"></b-loading>
    <div v-if="data_status">
      <p>Name: {{group_info.group_name}}</p>
      <p>Creator: {{group_info.creator_name}}</p>
      <br>SUBS: <br>
      <p v-for="item in subs_info"> {{ item.username }}</p>
    </div>
    <div v-else>
      Данные о группе не найдены
    </div>
  </div>
</template>

<script>
export default {
  name: "GroupPage",
  data(){
    return{
      group_info: [],
      subs_info: [],
      isLoading: true,
      data_status: true
    }
  },
  created() {
    this.$store.dispatch('getGroupInfo', this.$route.params.id)
        .then(res => {
          this.group_info = res.data.info.group_info
          this.subs_info = res.data.info.subs_info
          this.data_status = res.data.status
          this.isLoading = false
        })
    .catch(err => {
      this.data_status = err.data.status
      this.isLoading = false
    })
  }
}
</script>

<style scoped>

</style>
