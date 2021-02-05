
const KEY='VISIBLE_SCREEN_NAME';
export const FLICKR_SETS_SCREEN='flickr_sets';
export const FLICKR_SET_SCREEN='flickr_set';
export const FLICKR_PHOTO_SCREEN='flickr_photo';
export const FLICKR_UNIMPORTED_SETS_SCREEN='unimported_sets';
export const FLICKR_ORPHANED_PHOTOS='flickr_photo_orphan';

export const setScreen = (name) => {
    window.localStorage.setItem(KEY, name);
}

export const getScreen = () => {
    return window.localStorage.getItem(KEY);
}