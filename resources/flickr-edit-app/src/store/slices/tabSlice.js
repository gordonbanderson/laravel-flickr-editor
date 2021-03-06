import {createSlice} from '@reduxjs/toolkit'
import {HOME_TAB} from "../../components/constants/tabs";

export const mainTabSlice = createSlice({
    name: 'mainTab',
    initialState: {
        value: HOME_TAB
    },
    reducers: {
        selectTab: (state, action) => {
            state.value = action.payload
        }
    }
})

// Action creators are generated for each case reducer function
export const { selectTab } = mainTabSlice.actions

export default mainTabSlice.reducer