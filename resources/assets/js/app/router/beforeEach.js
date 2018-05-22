import store from './../vuex'

export const beforeEach = ((to, from, next) => {
    store.dispatch('authenticate');

    next()
})

export default beforeEach