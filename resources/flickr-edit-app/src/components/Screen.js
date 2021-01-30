
const KEY='VISIBLE_SCREEN_NAME';
export const FLICKR_SETS_SCREEN='flickr_sets';
export const FLICKR_SET_SCREEN='flickr_set';
export const FLICKR_PHOTO_SCREEN='flickr_photo';

export const setScreen = (name) => {
    window.localStorage.setItem(KEY, name);
}

export const getScreen = () => {
    return window.localStorage.getItem(KEY);
}