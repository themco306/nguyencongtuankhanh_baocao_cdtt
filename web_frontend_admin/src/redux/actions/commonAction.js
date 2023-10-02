import { COMMON_EROR_SET, COMMON_MESSAGE_SET, COMMON_MODAL_SET } from "./actionTypes"

export const setMessage=(message)=>(dispatch)=>{
    dispatch({
        type:COMMON_MESSAGE_SET,
        payload:message
    })
}
export const setError=(error)=>(dispatch)=>{
    dispatch({
        type:COMMON_EROR_SET,
        payload:error
    })
}
export const setLoading=(loading)=>(dispatch)=>{
    dispatch({
        type:COMMON_EROR_SET,
        payload:loading
    })

}
export const setModal=(modal)=>(dispatch)=>{
    dispatch({
        type:COMMON_MODAL_SET,
        payload:modal
    })
}