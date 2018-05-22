import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import user from './modules/user'
import image from './modules/image'

export default new Vuex.Store({
    modules: {
        user,
        image
    }
})