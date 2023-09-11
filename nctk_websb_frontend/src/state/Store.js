import { configureStore } from "@reduxjs/toolkit";
import cartReducer from './CartSlice'
import userReducer from './UserSlice'

export default configureStore({
    reducer: {
        cart: cartReducer,
        user:userReducer
    }
})
