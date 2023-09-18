import { TITLE_SET } from "./actionTypes"

export const setTitle=(title)=>(dispatch)=>{
    dispatch({
        type:TITLE_SET,
        payload:title
    })
}