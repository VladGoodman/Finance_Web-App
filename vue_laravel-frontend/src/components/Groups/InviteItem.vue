<template>
  <div class="container">
    <div class="invites">
      <div class="invites__left">
        <div class="invite__name">
          {{invite.group_name}}
        </div>
        <div class="invite__creator">
          Пригласил: <span class="invite__creator-name">{{invite.creator}}</span>
        </div>
      </div>
      <div class="invites__right">
        <div class="invite__btn">
          <b-button class="invite__btn-item" type="is-success" outlined @click="acceptInvite( invite.invite_id)">Принять</b-button>
          <b-button class="invite__btn-item" type="is-danger"  outlined @click="rejectInvite( invite.invite_id)">Отклонить</b-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "InviteItem",
  props:['invite'],
  methods:{
    acceptInvite(id){
      console.log(id)
      this.$store.dispatch('acceptInvite', id)
          .then(res => {
            this.$emit('update')
            console.log(res)
          })
    },
    rejectInvite(id){
      this.$store.dispatch('rejectInvite', id)
          .then(res => {
            this.$emit('update')
            console.log(res)
          })
    }
  }
}
</script>

<style scoped>
  .container{
    border: 1px solid #242B35;
    padding: 10px;
  }
  .invite__name{
    color: #242B35;
    font-weight: bold;
    font-size: 30px;
  }
  .invite__creator{
    color: #4E4E50;
  }
  .invite__creator-name{
    color: #F86B4F;
    font-size: 18px;
    font-weight: bold;
    margin-left: 10px;
  }
  .invites{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .invite__btn-item{
    margin: 0 5px;
  }
</style>
