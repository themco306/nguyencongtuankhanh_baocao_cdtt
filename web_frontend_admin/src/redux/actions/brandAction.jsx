import BrandService from "../../services/brandService";
import {
  BRANDS_SET,
  BRAND_APPEND,
  BRAND_DELETE,
  BRAND_SET,
  BRAND_SET_PAGEABLE,
  BRAND_UPDATE,
  COMMON_EROR_SET,
  COMMON_LOADING_SET,
  COMMON_MESSAGE_SET,
} from "./actionTypes";

export const insertBrand = (brand) => async (dispatch) => {
  const service = new BrandService();
  try {
    console.log("thêm brand", brand);
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });

    const response = await service.insertBrand(brand);
    console.log("response", response);
    if (response.status === 201) {
      dispatch({
        type: BRAND_SET,
        payload: response.data,
      });
      dispatch({
        type: BRAND_APPEND,
        payload: response.data,
      });
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
    console.log("error: " + e);
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

export const updateBrand = (brand) => async (dispatch) => {
  const service = new BrandService();
  try {
    console.log("sửa brand", brand);
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const { id } = brand;
    const response = await service.updateBrand(id, brand);
    console.log("response", response);
    if (response.status === 201) {
      dispatch({
        type: BRAND_SET,
        payload: response.data,
      });
      dispatch({
        type: BRAND_UPDATE,
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
    console.log("error: " + e);
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
export const getBrands = (params) => async (dispatch) => {
  const service = new BrandService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getBrands();
    console.log(response);
    if (response.status === 200) {
      dispatch({
        type: BRANDS_SET,
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
export const getBrandsByName = (params) => async (dispatch) => {
  const service = new BrandService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getBrandsByName(params);
    console.log(response);
    if (response.status === 200) {
      dispatch({
        type: BRANDS_SET,
        payload: response.data.content,
      });
      const {size,totalPages,totalElements,pageable} = response.data
      const pagination={
        size:size,
        page:pageable.pagenumber,
        query:params.query,
        totalPages:totalPages,
        totalElements:totalElements
      }
      dispatch({
        type:BRAND_SET_PAGEABLE,
        payload:pagination
      })
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
export const getBrand = (id) => async (dispatch) => {
  const service = new BrandService();
  try {
    console.log("list brand");

    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.getBrand(id);
    console.log(response);
    if (response.status === 200) {
      dispatch({
        type: BRAND_SET,
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
export const deleteBrand = (id) => async (dispatch) => {
  const service = new BrandService();
  console.log(id);
  try {
    dispatch({
      type: COMMON_LOADING_SET,
      payload: true,
    });
    const response = await service.deleteBrand(id);
    console.log("del", response);
    if (response.status === 200) {
      dispatch({
        type: BRAND_DELETE,
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
export const clearBrand = () => (dispatch) => {
  dispatch({
    type: BRANDS_SET,
    payload: {
      id: "",
      name: "",
      logo: "",
    },
  });
};
