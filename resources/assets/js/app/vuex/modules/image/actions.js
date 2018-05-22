import axios from 'axios'


export const uploadImage = ({ commit }, data) => {
    const config = { headers: { 'Content-Type': 'multipart/form-data' } };

    return axios.post(`/api/image/upload`, data, config).then((response) => {
        commit('storeUploadedImage', response.data.path)

        return Promise.resolve(response);
    })
}


export const saveImage = ({ commit }, data) => {
    return axios.post(`/api/image/save`, data).then((response) => {
        commit('addImage', response.data.image)
    })
}


export const cancelUploadedImage = ({ commit }, data) => {
    return axios.post('/api/image/cancel', data).then((response) => {
        commit('cancelUploadedImage')

        return Promise.resolve();
    })
}


// Home
export const getImages = ({ commit }) => {
    return axios.get(`/api/images`).then((response) => {
        commit('storeImages', response.data.images)
    })
}

// User
export const getAlbum = ({ commit }) => {
    return axios.get(`/api/album`).then((response) => {
        commit('storeImages', response.data.images)

        return Promise.resolve(response)
    })
}


// User
export const deleteImage = ({ commit, dispatch }, id) => {
    return axios.get(`/api/image/${id}/delete`).then((response) => {
        dispatch('getAlbum')
        dispatch('getFavorites')
    })
}


// User
export const getFavorites = ({ commit }) => {
    return axios.get(`/api/favorites`).then((response) => {
        commit('storeFavorites', response.data.images)
    })
}


// Explore
export const getImagesAndTags = ({ commit }, tags) => {
    return axios.post(`/api/images/tags`, tags).then((response) => {
        commit('storeImages', response.data.images)
        commit('storeTags', response.data.tags)
    })
}



export const likeImage = ({ commit }, id) => {
    return axios.get(`/api/image/${id}/like`).then((response) => {
        if (response.data.status === 'liked') {
            commit('addLike', response.data.like)
        } else if (response.data.status === 'unliked') {
            commit('deleteLike', response.data.like)
        }

        return Promise.resolve(response)
    })
}


export const deleteFavorite = ({ commit }, id) => {
    return axios.get(`/api/image/${id}/like`);
}