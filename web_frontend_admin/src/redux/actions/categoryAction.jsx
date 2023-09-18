import CategoryService from "../../services/categoryService"
import { CATEGORY_SET, CATEGORIES_SET, CATEGORY_STATE_CLEAR, COMMON_MESSAGE_SET, COMMON_EROR_SET, COMMON_LOADING_SET, CATEGORY_DELETE, TITLE_SET } from "./actionTypes";

export const insertCategory = (category, navigate) => async (dispatch) => {
    const service = new CategoryService();
    try {

      console.log('thêm category');
      dispatch({
        type:COMMON_LOADING_SET,
        payload:true
      })
      const response = await service.insertCategory(category);
      if (response.status === 201) {
        dispatch({
          type: CATEGORY_SET,
          payload: response.data,
        });
        dispatch({
            type :COMMON_MESSAGE_SET ,
            payload:"Lưu thành công"
        })
      }
      else{
        dispatch({
            type :COMMON_EROR_SET ,
            payload:response.message
        })
      }
      console.log(response);
    } catch (e) {
      console.log("error: " + e);
      dispatch({
        type :COMMON_EROR_SET ,
        payload:e.response.data?e.response.data.message:e.message
    })
    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
    navigate("/categories/list");
  };

  export const updateCategory = (id,category, navigate) => async (dispatch) => {
    const service = new CategoryService();
    try {
      console.log('sửa category');
      dispatch({
        type:COMMON_LOADING_SET,
        payload:true
      })
      const response = await service.updateCategory(id,category);
      if (response.status === 201) {
        dispatch({
          type: CATEGORY_SET,
          payload: response.data,
        });
        dispatch({
            type :COMMON_MESSAGE_SET ,
            payload:"Cập nhật thành công"
        })
      }
      else{
        dispatch({
            type :COMMON_EROR_SET ,
            payload:response.message
        })
      }
      console.log(response);
    } catch (e) {
      console.log("error: " + e);
      dispatch({
        type :COMMON_EROR_SET ,
        payload:e.response.data?e.response.data.message:e.message
    })
    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
    navigate("/categories/list");
  };
export const getCategories=()=>async(dispatch)=>{
    const service=new CategoryService()
    try {
        console.log('list category')

        dispatch({
            type:COMMON_LOADING_SET,
            payload:true
          })
        const res=await service.getCategories() 
        const response = await service.getCategories()
        console.log(response)
        if(response.status===200){
            dispatch({
                type:CATEGORIES_SET,
                payload:response.data
            })
        }else{
            dispatch({
                type :COMMON_EROR_SET ,
                payload:response.message
            })
        }

    } catch (e) {
        
        dispatch({
            type :COMMON_EROR_SET ,
            payload:e.response.data?e.response.data.message:e.message
        })

    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
}

export const deleteCategory=(id)=>async(dispatch)=>{
    const service=new CategoryService()
    console.log(id)
    try {
        dispatch({
            type:COMMON_LOADING_SET,
            payload:true
          })
        const response = await service.deleteCategory(id)
        console.log("del"+ response)
        if(response.status===200){
            dispatch({
                type:CATEGORY_DELETE,
                payload:id,
            })
            dispatch({
              type:COMMON_MESSAGE_SET,
              payload:response.data
            })
        }else{
            dispatch({
                type :COMMON_EROR_SET ,
                payload:response.message
            })
        }

    } catch (e) {
        
        dispatch({
            type :COMMON_EROR_SET ,
            payload:e.response.data?e.response.data.message:e.message
        })

    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
}

export const getCategory=(id)=>async(dispatch)=>{
  const service=new CategoryService()
 
  try {
    console.log("get category")
      dispatch({
          type:COMMON_LOADING_SET,
          payload:true
        })
      const response = await service.getCategory(id)
      console.log("get"+ response)
      if(response.status===200){
          dispatch({
              type:CATEGORY_SET,
              payload:response.data,
          })
      }else{
          dispatch({
              type :COMMON_EROR_SET ,
              payload:response.message
          })
      }

  } catch (e) {
      
      dispatch({
          type :COMMON_EROR_SET ,
          payload:e.response.data?e.response.data.message:e.message
      })

  }
  dispatch({
      type:COMMON_LOADING_SET,
      payload:false
    })
}
export const clearCategory=()=>(dispatch)=>{
    dispatch({type:CATEGORY_SET,
              payload:{
                id:'',
                name:'',
                status:0
              }
    })
}