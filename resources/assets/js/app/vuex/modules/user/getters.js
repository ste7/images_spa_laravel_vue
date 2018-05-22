export const authenticated = (state) => {
    return state.user.authenticated;
}


export const getUser = (state) => {
    return state.user;
}


export const getUploadedAvatar = (state) => {
    return state.avatar;
}