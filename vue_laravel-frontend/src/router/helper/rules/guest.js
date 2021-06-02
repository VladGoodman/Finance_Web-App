import store from '../../../store/store';

export default (to, from, next) => {
  if (store.getters['authenticated']) {
    next('/profile');
  } else {
    next();
  }
}
