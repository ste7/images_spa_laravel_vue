import store from './../vuex'

export const authenticate = (to, from, next) => {
    let authenticated = store.getters.authenticated;

    if (authenticated) {
        next()
    } else {
        next('/')
    }
}

export default authenticate