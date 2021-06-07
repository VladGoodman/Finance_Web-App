<template>
  <div class="container-list">
    <b-loading  v-model="isLoading" :can-cancel="false" :is-full-page="false"></b-loading>
    <b-modal
        v-model="isComponentModalActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Example Modal"
        aria-modal>
      <template #default="props">
        <modal-create @close="props.close"></modal-create>
      </template>
    </b-modal>
    <div class="groups__title">
      Группы
    </div>
    <div class="groups__content">
      <b-tabs type="is-boxed">
        <b-tab-item>
          <template #header>
            <span> Группы </span>
          </template>
          <div class="create__group">
            <div class="create__group-btn">
              <b-button
                  label="Создать группу"
                  type="is-link is-light"
                  size="is-medium"
                  @click="isComponentModalActive = true" />
            </div>
          </div>
          <div v-if="groups.length === 0" class="groups__err">
            Список групп пуст
          </div>
          <div v-if="groups.length" class="groups__body">
            <group-item v-on:update="getAccountGroups" v-for="item in groups" :group="item"/>
          </div>
        </b-tab-item>
        <b-tab-item>
          <template #header>
            <span>Приглашения</span>
          </template>

          <div v-if="invites.length === 0" class="invites__err">
            Список приглашений пуст
          </div>
          <div v-if="invites.length" class="invites__body">
            <invite-item v-on:update="getAccountGroups" v-for="item in invites" :invite="item" />
          </div>
        </b-tab-item>
      </b-tabs>
    </div>
  </div>
</template>

<script>
import GroupItem from "./GroupItem";
import InviteItem from "./InviteItem";
import ModalCreate from "./ModalCreate";

export default {
  name: "Groups",
  components: {InviteItem, GroupItem, ModalCreate},
  comments: [GroupItem,InviteItem],
  data(){
    return{
      groups: [],
      invites: [],
      isCardModalActive: false,
      isLoading: true,
      isComponentModalActive: false
    }
  },
  created() {
    this.getAccountGroups()
  },
  mounted() {
    document.title = "Группы | Finans"
  },
  methods:{
    getAccountGroups(){
      this.$store.dispatch('getGroupAccount')
          .then(res => {
            this.groups = res.data.info
            this.$store.dispatch('getAccountInvites')
                .then(res => {
                  this.invites = res.data.info
                  this.isLoading = false
                  console.log(this.groups)
                  console.log(this.invites)
                })
          })
    }
  }
}
</script>

<style>
  .container-list{
    padding: 30px;
    position: relative;
  }
  .container-list .tabs.is-boxed li.is-active a{
    background: transparent !important;
  }
  .container-list .tabs.is-boxed a:hover{
    background: transparent !important;
  }
  .container-list .tabs.is-boxed a:hover{
    background: transparent !important;
  }
  .container-list .tabs a {
    color: #3F3F3F !important;
    font-weight: bold !important;
  }
  .invites__err, .groups__err{
    color: #C3073F;
    font-size: 24px;
  }
  .groups__title{
    background-color: #A8CCEE;
    padding: 30px 30px;
    color: #3F3F3F;
    border-bottom: 4px solid #6E91B2;
    font-weight: normal;
    font-size: 24px;
  }
  .groups__content{
    background-color: white;
    min-height: 200px;
  }
  .create__group-btn{
    text-align: right;
  }
</style>
