import {configureStore} from '@reduxjs/toolkit';
import mainTabReducer from './slices/tabSlice';

export default configureStore({
    reducer: {
        mainTab: mainTabReducer
    }
})
