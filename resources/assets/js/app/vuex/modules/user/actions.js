import axios from 'axios'


export const register = ({ commit, dispatch }, data) => {
    return axios.post(`/api/register`, data).then((response) => {
        commit('storeUser', response.data.user.data)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        dispatch('setHttp')

        return Promise.resolve()
    })
}


export const login = ({ commit, dispatch }, data) => {
    return axios.post(`/api/login`, data).then((response) => {
        commit('storeUser', response.data.user.data)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        dispatch('setHttp')

        return Promise.resolve()
    })
}


export const logout = ({ commit, dispatch }) => {
    dispatch('setHttp');
    return axios.get(`/api/logout`).then(() => {
        commit('removeUser')
    })
}


export const setHttp = ({ commit }, token) => {
    let user = JSON.parse(localStorage.getItem('user'));
    if (user) {
        commit('storeUser', user.data);
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + user.token;

        return Promise.resolve(true);
    }
}


export const authenticate = ({ commit, dispatch }) => {
    dispatch('setHttp')
    return axios.get('/api/authenticate').then((response) => {
        localStorage.setItem('user', JSON.stringify(response.data.user))
        commit('storeUser', response.data.user.data)
    }).catch((error) => {
        commit('removeUser')
    });
}



export const uploadAvatar = ({ commit }, data) => {
    const config = { headers: { 'Content-Type': 'multipart/form-data' } };

    return axios.post(`/api/avatar/upload`, data, config).then((response) => {
        commit('storeUploadedAvatar', response.data.path)

        return Promise.resolve(response)
    })
}


export const saveAvatar = ({ commit }, data) => {
    return axios.post('/api/avatar/save', data).then((response) => {
        let user = JSON.parse(localStorage.user);
        user.data.avatar = response.data.path;
        localStorage.setItem('user', JSON.stringify(user));

        commit('storeAvatar', response.data.path)
        commit('canceledUploadAvatar')

        return Promise.resolve(response)
    });
}


export const cancelAvatarUpload = ({ commit }, data) => {
    return axios.post('/api/avatar/cancel', data).then((response) => {
        commit('canceledUploadAvatar')
        commit('storeAvatar', response.data.path)

        return Promise.resolve(response)
    })
}