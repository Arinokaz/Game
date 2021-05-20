import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
import auth from "./middlewares/auth";
import middlewarePipeline from "./middlewarePipeline";

import Login from "../views/Login.vue";
import Game from "../views/Game.vue";

const routes = [
  {
    path: "/",
    name: "login",
    component: Login,
  },
  {
    path: "/game",
    name: "game",
    component: Game,
    meta: {
      middleware: [auth],
    },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (!to.meta.middleware) {
    return next();
  }
  const { middleware } = to.meta;
  const context = {
    to,
    from,
    next,
    store,
  };
  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  });
});

export default router;
