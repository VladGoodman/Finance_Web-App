<template>
  <div class="container">
    <b-loading v-model="isLoading" :can-cancel="false" :is-full-page="false"></b-loading>

    <div v-if="data_status">
      <div class="group__info">
        <div class="group__info-title">
          Группа: <span class="info-title__name">{{group_info.group_name}}</span>
        </div>
        <div class="group__info-container">
          <div class="info-container__creator">
            Создатель группы: <span id="creator">{{group_info.creator_name}}</span>
          </div>
          <div class="info-container__subscribers">
            <div class="subscribers__title">
              Люди в группе:
            </div>
            <p v-for="item in subs_info"> {{ item.username }}</p>
          </div>
        </div>
      </div>
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
      data_status: false
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
  .container{
    padding: 30px;
  }
  .group__info-title{
    background-color: #A8CCEE;
    padding: 30px 30px;
    color: #3F3F3F;
    border-bottom: 4px solid #6E91B2;
    font-weight: normal;
    font-size: 24px;
  }
  .info-title__name{
    color: #F86B4F;
  }
  .group__info-container{
    background-color: white;
  }
  .info-container__creator{
    padding: 10px 30px;
    border-bottom: 1px solid #4E4E50;
  }
  #creator{
    color: #F86B4F;
  }
  .info-container__subscribers{
    padding: 10px 30px;

  }
  .subscribers__title{
    margin-bottom: 20px;
  }
</style>
