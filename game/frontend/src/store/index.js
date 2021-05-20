import { createStore } from "vuex";

export default createStore({
  state: {
    login: false,
    user: {},
  },
  getters: {
    isLogin: (state) => {
      return state.login;
    },
    User: (state) => {
      return state.user
    }
  },
  mutations: {
    LOGIN(state, user) {
      state.login = true;
      state.user = user;
    },
  },
  actions: {},
});
