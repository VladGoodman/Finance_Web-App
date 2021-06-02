import axios from "axios";
import store from '../store/store'
let instance = axios.create({
  withCredentials: true,
});

instance.interceptors.request.use(request => {
  request.headers.common['Accept']       = 'application/json';
  request.headers.common['Content-Type'] = 'application/json';
  if(store.getters['user']){
    console.log("API USER IS TRUE")
    console.log(store.getters['user'])
    request.headers.common['Authorization'] = 'Bearer '+store.getters['user'];
  }
  return request;
});

instance.interceptors.response.use(
  response => response,
  error => Promise.reject(error.response)
);


export default instance;
