import {createSlice} from '@reduxjs/toolkit'
import {HOME_TAB} from "../../components/constants/tabs";

export const statusSlice = createSlice({
    name: 'status',
    initialState: {
        value: HOME_TAB
    },
    // @todo appropriate actions
    reducers: {
        selectTab: (state, action) => {
            state.value = action.payload
        }
    }
})

// Action creators are generated for each case reducer function
export const { selectTab } = statusSlice.actions

export default statusSlice.reducer