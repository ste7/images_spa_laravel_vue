export const storeUser = (state, user) => {
    state.user.data = user;
    state.user.authenticated = true;
}


export const removeUser = (state, user) => {
    state.user.data = null;
    state.user.authenticated = false;
    localStorage.removeItem('user');
}


export const storeAvatar = (state, avatar) => {
    state.user.data.avatar = avatar;
}


export const storeUploadedAvatar = (state, path) => {
    state.avatar.path = path;
    state.avatar.uploaded = true;
}


export const canceledUploadAvatar = (state) => {
    state.avatar.path = null;
    state.avatar.uploaded = false;
}