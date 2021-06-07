import Vue from 'vue'
import Vuex from 'vuex'

import repository from '../api/repository'
import axios from "axios";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: localStorage.getItem('user') || null,
        username: localStorage.getItem('username'),
        user_names: JSON.parse(localStorage.getItem('user_names')),
        converter_data: JSON.parse(localStorage.getItem('converter_data')),
        user_sum_change: localStorage.getItem('user_sum_change'),
        last_update_converter: localStorage.getItem('last_update_converter')
    },
    getters: {
        user: state => state.user,
        authenticated: state => state.user !== null,
        names: state => state.user_names,
        username: state => state.username,
        converter_data: state => state.converter_data,
        user_sum_change: state => state.user_sum_change,
        last_update_converter: state => state.last_update_converter,
    },
    mutations: {
        SET_USER(state, user) {
            console.log(user)
            state.user = user.token
            localStorage.setItem('user', user.token)
        },
        LOGOUT_USER(state) {
            state.user = null
            localStorage.removeItem('user')
            console.log(state.user)
        },
        SET_USER_INFO(state, info) {
            console.log(info)
            state.username = info.user[0]
            state.user_names = info.user[1]
            state.user_sum_change = info.sum_changes
            localStorage.setItem('username', info.user[0])
            localStorage.setItem('user_names', JSON.stringify(info.user[1]))
            localStorage.setItem('user_sum_change', info.sum_changes)
        }
    },
    actions: {
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                repository.createSession()
                    .then(res => {
                        repository.login(user)
                            .then((res) => {
                                if (res.status === 201) {
                                    console.log('Login is true')
                                    commit('SET_USER', res.data)
                                }
                                resolve(res)
                            })
                            .catch((err) => {
                                console.log('Login is false')
                                reject(err)
                            })
                    })
            })
        },
        getAccountInfo({commit}) {
            return new Promise((resolve, reject) => {
                repository.getAccountInfo()
                    .then((res) => {
                        let result = {}
                        result.user = res.data.user
                        result.sum_changes = 0
                        res.data.changes.forEach((el)=>{
                            if(el.change_id === 2){
                                result.sum_changes += el.quantity
                            }else if(el.change_id === 1){
                                result.sum_changes -= el.quantity
                            }
                        })
                        commit('SET_USER_INFO', result)
                        resolve(res)
                    })
                    .catch((err) => {
                        console.log(err)
                        reject(err)
                    })
            })
        },
        logout({commit}) {
            return new Promise((resolve) => {
                localStorage.removeItem('user')
                repository.logout()
                    .then((res) => {
                        commit('LOGOUT_USER')
                        resolve(true)
                    })
                    .catch((err) => {
                        console.log(err.response.data.errors)
                    })
            })
        },
        register({commit}, user) {
            return new Promise((resolve, reject) => {
                repository.register(user)
                    .then((res) => {
                        console.log(res)
                        commit('SET_USER', res.data)
                        resolve(res)
                    })
                    .catch((err) => {
                        console.log('Register is false')
                        reject(err)
                    })
            })
        },
        getAccountChanges() {
            return new Promise((resolve, reject) => {
                repository.AccountChanges()
                    .then((res) => {
                        resolve(res)
                    })
                    .catch((err) => {
                        reject(err)
                    })
            })
        },
        getUserInfo() {
            return new Promise((resolve, reject) => {
                repository.getAccountInfo()
                    .then((res) => {
                        resolve(res)
                    })
                    .catch((err) => {
                        reject(err)
                    })
            })
        },
        createUserChange({commit}, params) {
            console.log(params)
            repository.createAccountChange(params)
                .then((res) => {
                    console.log(res)
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        deleteChangeAccount({commit}, id) {
            console.log(id)
            repository.deleteChangeAccount({id: id})
                .then(res => console.log(res.data))
                .catch(err => console.log(err));
        },
        converterCheck({commit}){
            axios.get('https://www.cbr-xml-daily.ru/daily_json.js')
                .then(res => {
                    localStorage.setItem('converter_data', JSON.stringify(res.data.Valute))
                    let date_for_validate = new Date(res.data.PreviousDate)
                    let date = ( date_for_validate.getDate() )+"."+ ( date_for_validate.getMonth()+1 )+"."+ ( date_for_validate.getFullYear() )
                        + " " + ( date_for_validate.getHours() )+":" + ( date_for_validate.getMinutes() ) ;
                    localStorage.setItem('last_update_converter', date)
                })
        },
        getGroupAccount(){
            return new Promise((resolve, reject) => {
                repository.getAccountGroups().then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        getAccountInvites(){
            return new Promise((resolve, reject) => {
                repository.getAccountInvites().then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        acceptInvite({commit},id){
            return new Promise((resolve, reject) => {
                repository.acceptInvite({invite_id:id}).then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        rejectInvite({commit},id){
            return new Promise((resolve, reject) => {
                repository.rejectInvite({invite_id:id}).then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        leaveGroup({commit},id){
            console.log(id)
            return new Promise((resolve, reject) => {
                repository.leaveGroup({participation_id:id}).then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        getGroupInfo({commit},id){
            console.log(id)
            return new Promise((resolve, reject) => {
                repository.getGroupInfo({group_id:id}).then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        createGroup({commit}, name){
            return new Promise((resolve, reject) => {
                repository.createGroup(name)
                    .then((res) => {
                        console.log(res)
                        resolve(res)
                    })
                    .catch((err) => {
                        console.log(err)
                        reject(err)
                    })
            })
        },
        searchUsers({commit}, username){
            return new Promise((resolve, reject) => {
                repository.searchUsers(username)
                    .then((res) => {
                        console.log(res)
                        resolve(res)
                    })
                    .catch((err) => {
                        console.log(err)
                        reject(err)
                    })
            })
        },
        createInvite({commit}, params){
            return new Promise((resolve, reject) => {
                repository.createInvite(params)
                    .then((res) => {
                        resolve(res)
                    })
                    .catch((err) => {
                        reject(err)
                    })
            })
        }
    }
})
