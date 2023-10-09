import { Navigate, useNavigate } from "react-router-dom";
import ProductService from "../../services/productService";
import {

  COMMON_EROR_SET,
  COMMON_LOADING_SET,
  COMMON_MESSAGE_SET,
  PRODUCTS_SET,
  PRODUCT_APPEND,
  PRODUCT_DELETE,
  PRODUCT_SET,
  PRODUCT_SET_PAGEABLE,
  PRODUCT_UPDATE,
} from "./actionTypes";

export const insertProduct = (product,navigate) => async (dispatch) => {

  const service = new ProductService();
  try {
    console.log("thêm product", product);
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });

    const response = await service.insertProduct(product);
    console.log("response", response);
    if (response.status === 201) {
      dispatch({
        type: PRODUCT_SET,
        payload: response.data,
      });
      // dispatch({
      //   type: PRODUCT_APPEND,
      //   payload: response.data,
      // });
      dispatch({
        type: COMMON_MESSAGE_SET,
        payload: "Lưu thành công",
      });
    } else {
      dispatch({
        type: COMMON_EROR_SET,
        payload: response.message,
      });
    }
  } catch (e) {
    console.log("error: " , e);
    dispatch({
      type: COMMON_EROR_SET,
      payload: e.response.data ? e.response.data.message : e.message,
    });
  }
  dispatch({
    type: COMMON_LOADING_SET,
    payload: false,
  });
  navigate("/products/list")
};
export const updateProduct = (brand) => async (dispatch) => {
  const navigate = useNavigate();
  const service = new ProductService();
  try {
    console.log("sửa brand", brand);
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    // let formData = new FormData();
    // formData.append("name", brand.name);
    // formData.append("metakey", brand.metakey);
    // formData.append("metadesc", brand.metadesc);
    // formData.append("sortOrder", brand.sortOrder);
    // const status = brand.status !== undefined ? brand.status : 0;
    // formData.append("status", status);
    // if(brand.logoFile[0].originFileObj){
    //   formData.append("logoFile",brand.logoFile[0].originFileObj)
    //   }
    const { id } = brand;
    const response = await service.updateBrand(id, brand);
    console.log("response", response);
    if (response.status === 201) {
      dispatch({
        type: PRODUCT_SET,
        payload: response.data,
      });
      dispatch({
        type: PRODUCT_UPDATE,
        payload: response.data,
      });
      dispatch({
        type: COMMON_MESSAGE_SET,
        payload: "Sửa thành công",
      });
    } else {
      dispatch({
        type: COMMON_EROR_SET,
        payload: response.message,
      });
    }
  } catch (e) {
    console.log("error: " , e);
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
export const getProducts=()=>async(dispatch)=>{
  const service=new ProductService()
  try {
      console.log('list PRODUCTS_SET')

      dispatch({
          type:COMMON_LOADING_SET,
          payload:true
        })
  
      const response = await service.getProducts()
      console.log(response)
      if(response.status===200){
          dispatch({
              type:PRODUCTS_SET,
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
export const deleteProduct = (id) => async (dispatch) => {
  const service = new ProductService();
  console.log(id);
  try {
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.deleteProduct(id);
    console.log("del", response);
    if (response.status === 200) {
      dispatch({
        type: PRODUCT_DELETE,
        payload: id,
      });
      dispatch({
        type: COMMON_MESSAGE_SET,
        payload: response.data,
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
export const updateProductStatus = (id) => async (dispatch) => {
  const service = new ProductService();
  try {

    console.log("sửa changeStatus", id);
    const response = await service.updateProductStatus(id);
    console.log("response", response);
    if (response.status === 200) {
      dispatch({
        type: PRODUCT_SET,
        payload: response.data,
      });
      dispatch({
        type: PRODUCT_UPDATE,
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
export const getProductsByName = (params) => async (dispatch) => {
  const service = new ProductService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getProductsByName(params);
    console.log(response);
    if (response.status === 200) {
      dispatch({
        type: PRODUCTS_SET,
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
        type: PRODUCT_SET_PAGEABLE,
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
export const getProduct = (id) => async (dispatch) => {
  const service = new ProductService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getProduct(id);
    console.log(response);
    if (response.status === 200) {
      console.log("set brand")
      dispatch({
        type: PRODUCT_SET,
        payload: response.data,
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
export const clearProduct=()=>(dispatch)=>{
  dispatch({type:PRODUCT_SET,
            payload:{
              product: {
                id: null,
                name: null,
                price: null,
                is_featured: null,
                manufacture_date: null,
                metakey: null,
                metadesc: null,
                status: null,
                category_id: null,
                brand_id: null,
                image: null,
                detail: null,
                description: null
              }
            }
  })
}
// export const updateProduct = (product) => async (dispatch) => {
//   const service = new ProductService();
//   try {
//     console.log("sửa product", product);
//     dispatch({
//       type: COMMON_LOADING_SET,
//       payload: true,
//     });
//     const { id } = product;
//     const response = await service.updateProduct(id, product);
//     console.log("response", response);
//     if (response.status === 201) {
//       dispatch({
//         type: PRODUCT_SET,
//         payload: response.data,
//       });
//       dispatch({
//         type: PRODUCT_UPDATE,
//         payload: response.data,
//       });
//       dispatch({
//         type: COMMON_MESSAGE_SET,
//         payload: "Sửa thành công",
//       });
//     } else {
//       dispatch({
//         type: COMMON_EROR_SET,
//         payload: response.message,
//       });
//     }
//   } catch (e) {
//     console.log("error: " + e);
//     dispatch({
//       type: COMMON_EROR_SET,
//       payload: e.response.data ? e.response.data.message : e.message,
//     });
//   }
//   dispatch({
//     type: COMMON_LOADING_SET,
//     payload: false,
//   });
// };
// export const getProducts = (params) => async (dispatch) => {
//   const service = new ProductService();
//   try {
//     console.log("list product");

//     dispatch({
//       type: COMMON_LOADING_SET,
//       payload: true,
//     });
//     const response = await service.getProducts();
//     console.log(response);
//     if (response.status === 200) {
//       dispatch({
//         type: PRODUCTS_SET,
//         payload: response.data,
//       });
//     } else {
//       dispatch({
//         type: COMMON_EROR_SET,
//         payload: response.message,
//       });
//     }
//   } catch (e) {
//     dispatch({
//       type: COMMON_EROR_SET,
//       payload: e.response.data ? e.response.data.message : e.message,
//     });
//   }
//   dispatch({
//     type: COMMON_LOADING_SET,
//     payload: false,
//   });
// };
// export const getProductsByName = (params) => async (dispatch) => {
//   const service = new ProductService();
//   try {
//     console.log("list product");

//     dispatch({
//       type: COMMON_LOADING_SET,
//       payload: true,
//     });
//     const response = await service.getProductsByName(params);
//     console.log(response);
//     if (response.status === 200) {
//       dispatch({
//         type: PRODUCTS_SET,
//         payload: response.data.content,
//       });
//       const {size,totalPages,totalElements,pageable} = response.data
//       const pagination={
//         size:size,
//         page:pageable.pagenumber,
//         query:params.query,
//         totalPages:totalPages,
//         totalElements:totalElements
//       }
//       dispatch({
//         type:PRODUCT_SET_PAGEABLE,
//         payload:pagination
//       })
//     } else {
//       dispatch({
//         type: COMMON_EROR_SET,
//         payload: response.message,
//       });
//     }
//   } catch (e) {
//     dispatch({
//       type: COMMON_EROR_SET,
//       payload: e.response.data ? e.response.data.message : e.message,
//     });
//   }
//   dispatch({
//     type: COMMON_LOADING_SET,
//     payload: false,
//   });
// };
// export const getProduct = (id) => async (dispatch) => {
//   const service = new ProductService();
//   try {
//     console.log("list product");

//     dispatch({
//       type: COMMON_LOADING_SET,
//       payload: true,
//     });
//     const response = await service.getProduct(id);
//     console.log(response);
//     if (response.status === 200) {
//       dispatch({
//         type: PRODUCT_SET,
//         payload: response.data,
//       });
//     } else {
//       dispatch({
//         type: COMMON_EROR_SET,
//         payload: response.message,
//       });
//     }
//   } catch (e) {
//     dispatch({
//       type: COMMON_EROR_SET,
//       payload: e.response.data ? e.response.data.message : e.message,
//     });
//   }
//   dispatch({
//     type: COMMON_LOADING_SET,
//     payload: false,
//   });
// };
// export const deleteProduct = (id) => async (dispatch) => {
//   const service = new ProductService();
//   console.log(id);
//   try {
//     dispatch({
//       type: COMMON_LOADING_SET,
//       payload: true,
//     });
//     const response = await service.deleteProduct(id);
//     console.log("del", response);
//     if (response.status === 200) {
//       dispatch({
//         type: PRODUCT_DELETE,
//         payload: id,
//       });
//       dispatch({
//         type: COMMON_MESSAGE_SET,
//         payload: response.data,
//       });
//     } else {
//       dispatch({
//         type: COMMON_EROR_SET,
//         payload: response.message,
//       });
//     }
//   } catch (e) {
//     dispatch({
//       type: COMMON_EROR_SET,
//       payload: e.response.data ? e.response.data.message : e.message,
//     });
//   }
//   dispatch({
//     type: COMMON_LOADING_SET,
//     payload: false,
//   });
// };
// export const clearProduct = () => (dispatch) => {
//   dispatch({
//     type: PRODUCTS_SET,
//     payload: {
//       id: "",
//       name: "",
//       logo: "",
//     },
//   });
// };
