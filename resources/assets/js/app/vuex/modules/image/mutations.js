export const storeUploadedImage = (state, path) => {
    state.image.path = path;
    state.image.uploaded = true;
}


export const cancelUploadedImage = (state) => {
    state.image.path = null;
    state.image.uploaded = false;
}


export const storeImages = (state, images) => {
    state.images = images;
}


export const addImage = (state, image) => {
    // state.images.unshift(image);
    state.image.uploaded = false;
}


export const storeTags = (state, tags) => {
    state.tags = tags;
}


export const addLike = (state, like) => {
    let index = state.images.findIndex(i => i.id == like.image_id);

    state.images[index].likes.push(like);
}


export const deleteLike = (state, like) => {
    let index = state.images.findIndex(i => i.id == like.image_id);

    state.images[index].likes.pop();
}


export const storeFavorites = (state, images) => {
    state.favorites = images;
}