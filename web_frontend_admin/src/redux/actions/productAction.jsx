import { Navigate } from "react-router-dom";
import ProductService from "../../services/productService";
import {

  COMMON_EROR_SET,
  COMMON_LOADING_SET,
  COMMON_MESSAGE_SET,
  PRODUCT_APPEND,
  PRODUCT_SET,
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
