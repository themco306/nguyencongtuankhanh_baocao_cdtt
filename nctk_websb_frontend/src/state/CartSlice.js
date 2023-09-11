// import { createSlice } from "@reduxjs/toolkit";

// export const cartSlice = createSlice({
//     name: "cart",
//     initialState: {
//         items:localStorage.getItem('cart')?JSON.parse(localStorage.getItem('cart')) : []
//     },
//     reducers:{
//         addToCart: (state, action) => {
//             const { item } = action.payload;
//             const existingItemIndex = state.items.findIndex((i) => i.id === item.id);
//             if (existingItemIndex === -1) {
//               state.items.push({ ...item, count: 1 });

//             } else {
//               state.items[existingItemIndex].count++;
//             }
//               // Lưu giỏ hàng vào localStorage
//             localStorage.setItem('cart', JSON.stringify(state.items));
//         },
//         removeFromCart:(state,action)=>{
//             state.items=state.items.filter((item)=>{
//                 return item.id !== action.payload.id
//             })
//               // Xóa giỏ hàng khỏi localStorage
//             localStorage.removeItem("cart");
//             // Lưu giỏ hàng mới vào localStorage
//             localStorage.setItem("cart", JSON.stringify(state.items));
//         },
//         increaseCount:(state,action)=>{
//             state.items=state.items.map((item)=>{
//                 if(item.id === action.payload.id){
//                     item.count++
//                 }
//                 return item
//             })
//               // Lưu giỏ hàng mới vào localStorage
//             localStorage.setItem("cart", JSON.stringify(state.items));
//         },
//         decreaseCount:(state,action)=>{
//             state.items=state.items.map((item)=>{
//                 if(item.id === action.payload.id && item.count>1){
//                     item.count--
//                 }
//                 return item
//             })
//               // Lưu giỏ hàng mới vào localStorage
//               localStorage.setItem("cart", JSON.stringify(state.items));
//         },
//         clearCart:(state)=> {
//             state.items=[]
//             // Xóa giỏ hàng khỏi localStorage
//             localStorage.clear();
//             }
//     }
// })
// export const{
//     addToCart,
//     removeFromCart,
//     increaseCount,
//     decreaseCount,
//     clearCart
// }=cartSlice.actions
// export default cartSlice.reducer