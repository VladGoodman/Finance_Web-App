import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/Index.vue'
import Auth from '../views/Auth.vue'
import Logout from '../components/Logout.vue'
import Profile from '../views/Profile.vue'
import ListChanges from '../components/ListСhanges/ListChanges'
import helper from './helper/helper'
import TimeStatistics from '../components/TimeStatistics/TimeStatistics'
import Converter from "../components/Converter/Converter";
import Groups from "../components/Groups/Groups";
import GroupPage from "../components/Groups/GroupPage";
import SearchUsers from "../components/Groups/SearchUsers/SearchUsers";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Index',
    component: Index
  },
  {
    path: '/auth',
    name: 'Auth',
    component: Auth,
    beforeEnter: helper.guest
  },
  {
    path: '/logout',
    name: 'Logout',
    component: Logout,
    beforeEnter: helper.user
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile,
    beforeEnter: helper.user,
    children: [
      {
        path: '/',
        name: 'profileIndex',
        component: ListChanges
      },
      {
        path: 'time',
        name: 'profileTime',
        component: TimeStatistics
      },
      {
        path: 'converter',
        name: 'profileConverter',
        component: Converter
      },
      {
        path: 'groups',
        name: 'profileGroups',
        component: Groups,
      },
      {
        path: 'groups/:id',
        name: 'group',
        component: GroupPage,
      },
      {
        path: 'groups/:id/invite',
        name: 'groupInvite',
        component: SearchUsers,
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
