import api from "./api"

export default {
  createSession(){
    return api.get('http://127.0.0.1:8000/sanctum/csrf-cookie');
  },
  login(params){
    return api.post('http://127.0.0.1:8000/api/login', params);
  },
  register(params){
    return api.post('http://127.0.0.1:8000/api/register', params);
  },
  test(){
    return api.get('http://127.0.0.1:8000/api/test');
  },
  logout(){
    return api.delete('http://127.0.0.1:8000/api/logout');
  },
  AccountChanges(){
    return api.get('http://127.0.0.1:8000/api/user/changes');
  },
  getAccountInfo(){
    return api.get('http://127.0.0.1:8000/api/user');
  },
  createAccountChange(params){
    return api.post('http://127.0.0.1:8000/api/user/changes/create', params);
  },
  deleteChangeAccount(params){
    return api.post('http://127.0.0.1:8000/api/user/changes/delete', params);
  },
  getAccountGroups(){
    return api.get('http://127.0.0.1:8000/api/groups');
  },
  getAccountInvites(){
    return api.get('http://127.0.0.1:8000/api/invite/get');
  },
  acceptInvite(id){
    return api.post('http://127.0.0.1:8000/api/invite/success', id);
  },
  rejectInvite(params){
    return api.delete('http://127.0.0.1:8000/api/invite/reject', {data:params});
  },
  leaveGroup(params){
    return api.delete('http://127.0.0.1:8000/api/groups/leave', {data:params});
  },
  getGroupInfo(params) {
    return api.get('http://127.0.0.1:8000/api/group', {params});
  },
  createGroup(name){
    return api.post('http://127.0.0.1:8000/api/groups/create', {name: name});
  },
  searchUsers(username){
    return api.post('http://127.0.0.1:8000/api/user/search', {username: username});
  },
  createInvite(params){
    return api.post('http://127.0.0.1:8000/api/invite/create', {recipient_id: params.user_id, group_id: params.group_id});
  }
}
