import CategoryService from "../../services/categoryService"
import { CATEGORY_SET, CATEGORIES_SET, CATEGORY_STATE_CLEAR, COMMON_MESSAGE_SET, COMMON_EROR_SET, COMMON_LOADING_SET, CATEGORY_DELETE, TITLE_SET, CATEGORY_UPDATE, CATEGORY_SET_PAGEABLE, CATEGORY_APPEND, CATEGORY_GET_PARENT, CATEGORY_GET_SORTORDER, COMMON_MODAL_SET } from "./actionTypes";

export const insertCategory = (category) => async (dispatch) => {
    const service = new CategoryService();
    try {

      console.log('thêm category',category);
      dispatch({
        type:COMMON_LOADING_SET,
        payload:true
      })
      
      const response = await service.insertCategory(category);
    console.log("response", response);

      if (response.status === 201) {
        dispatch({
          type: CATEGORY_SET,
          payload: response.data,
        });
        dispatch({
          type: CATEGORY_APPEND,
          payload: response.data,
        });
        dispatch({
            type :COMMON_MESSAGE_SET ,
            payload:"Lưu thành công"
        })
      }
      else{
        dispatch({
          type :COMMON_MODAL_SET ,
          payload:true
      })
      }
      console.log(response);
    } catch (e) {
      console.log("error: ",e);
      dispatch({
        type :COMMON_MODAL_SET ,
        payload:true
    })
      dispatch({
        type :COMMON_EROR_SET ,
        payload:e.response.data?e.response.data.message:e.message
    })
    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
  };

  export const updateCategory = (category) => async (dispatch) => {
    const service = new CategoryService();
    try {
      console.log('sửa category',category);
      dispatch({
        type:COMMON_LOADING_SET,
        payload:true
      })
      const {id}=category
      const response = await service.updateCategory(id,category);
      console.log("response", response);
      if (response.status === 201) {
        dispatch({
          type: CATEGORY_SET,
          payload: response.data,
        });
        dispatch({
          type: CATEGORY_UPDATE,
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
      console.log("error: " ,e);
      dispatch({
        type :COMMON_EROR_SET ,
        payload:e.response.data?e.response.data.message:e.message
    })
    }
    dispatch({
        type:COMMON_LOADING_SET,
        payload:false
      })
  };
export const getCategories=()=>async(dispatch)=>{
    const service=new CategoryService()
    try {
        console.log('list category')

        dispatch({
            type:COMMON_LOADING_SET,
            payload:true
          })
    
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
export const getCategoriesByName = (params) => async (dispatch) => {
  const service = new CategoryService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getCategoriesByName(params);
    console.log(response);
    if (response.status === 200) {
      dispatch({
        type: CATEGORIES_SET,
        payload: response.data.content,
      });
      const { size, totalPages, totalElements, pageable } = response.data;
      const pagination = {
        size: size,
        page: pageable.pagenumber,
        query: params.query,
        totalPages: totalPages,
        totalElements: totalElements,
      };
      dispatch({
        type: CATEGORY_SET_PAGEABLE,
        payload: pagination,
      });
    } else {
      dispatch({
        type: COMMON_EROR_SET,
        payload: response.message,
      });
    }
  } catch (e) {
    dispatch({
      type: COMMON_EROR_SET,
      payload: e.response.data ? e.response.data.message : e.message,
    });
  }
  dispatch({
    type: COMMON_LOADING_SET,
    payload: false,
  });
};
export const updateCategoryStatus = (id) => async (dispatch) => {
  const service = new CategoryService();
  try {
    console.log("sửa changeStatus", id);
    const response = await service.updateCategoryStatus(id);
    console.log("response", response);
    if (response.status === 200) {
      dispatch({
        type: CATEGORY_SET,
        payload: response.data,
      });
      dispatch({
        type: CATEGORY_UPDATE,
        payload: response.data,
      });
      dispatch({
        type: COMMON_MESSAGE_SET,
        payload: "Thay đổi thành công",
      });
    } else {
      dispatch({
        type: COMMON_EROR_SET,
        payload: response.message ,
      });
    }
  } catch (e) {
    console.log("error: " + e);
    dispatch({
      type: COMMON_EROR_SET,
      payload: e.response.data ? e.response.data.message : e.message,
    });
  }
};
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

export const getCategory = (id) => async (dispatch) => {
  const service = new CategoryService();
  try {
    console.log("list getCategory");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getCategory(id);
    console.log(response);
    if (response.status === 200) {
      console.log("set getCategory");
      const categoryData = response.data;
      dispatch({
        type: CATEGORY_SET,
        payload: categoryData,
      });
      // Cập nhật parentCategory nếu parentId khác 0
      const parentId = categoryData.parent_id;
      if (parentId && parentId !== 0) {
        const parentResponse = await service.getCategory(parentId);
        

        if (parentResponse.status === 200) {
          const parentCategoryData = parentResponse.data.name;
          console.log("set parentCategoryData",parentCategoryData);
          dispatch({
            type: CATEGORY_GET_PARENT,
            payload: parentCategoryData,
          });
        }
      } 
      else{
        dispatch({
          type: CATEGORY_GET_PARENT,
          payload: "",
        });
      }
      const sortOrder = categoryData.sortOrder;
      if (sortOrder && sortOrder !== 0) {
        const parentResponse = await service.getCategory(sortOrder);
        

        if (parentResponse.status === 200) {
          const parentCategoryData = parentResponse.data.name;
          dispatch({
            type: CATEGORY_GET_SORTORDER,
            payload: parentCategoryData,
          });
        }
      } 
      else{
        dispatch({
          type: CATEGORY_GET_SORTORDER,
          payload: "",
        });
      }
    } else {
      dispatch({
        type: COMMON_EROR_SET,
        payload: response.message,
      });
    }
  } catch (e) {
    dispatch({
      type: COMMON_EROR_SET,
      payload: e.response.data ? e.response.data.message : e.message,
    });
  }
  dispatch({
    type: COMMON_LOADING_SET,
    payload: false,
  });
};
export const clearCategory=()=>(dispatch)=>{
    dispatch({type:CATEGORY_SET,
              payload:{
                  id: "",
                  name: "",
                  parent_id: 0,
                  metakey: "",
                  metadesc: "",
                  sortOrder: 0,
                  status: 0,
              }
    })
}