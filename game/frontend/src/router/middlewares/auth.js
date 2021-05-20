export default function auth({ to, next, store }) {
  if (!store.getters.isLogin) {
    return next({
      name: 'login',
    });
  }
   return next();
}
