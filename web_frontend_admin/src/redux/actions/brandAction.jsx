import BrandService from "../../services/brandService";
import {
  BRANDS_SET,
  BRAND_APPEND,
  BRAND_DELETE,
  BRAND_SET,
  BRAND_SET_PAGEABLE,
  BRAND_SET_STATUS,
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
    let formData = new FormData();
    formData.append("name", brand.name);
    formData.append("metakey", brand.metakey);
    formData.append("metadesc", brand.metadesc);
    const sortOrder = brand.sortOrder !== undefined ? brand.sortOrder : 0;
    formData.append("sortOrder", sortOrder);
    const status = brand.status !== undefined ? brand.status : 0;
    formData.append("status", status);
    if(brand.logoFile[0].originFileObj){
      formData.append("logoFile",brand.logoFile[0].originFileObj)
      }
    const response = await service.insertBrand(formData);
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
    console.log("error: ", e);
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
    let formData = new FormData();
    formData.append("name", brand.name);
    formData.append("metakey", brand.metakey);
    formData.append("metadesc", brand.metadesc);
    formData.append("sortOrder", brand.sortOrder);
    const status = brand.status !== undefined ? brand.status : 0;
    formData.append("status", status);
    if(brand.logoFile[0].originFileObj){
      formData.append("logoFile",brand.logoFile[0].originFileObj)
      }
    const { id } = brand;
    const response = await service.updateBrand(id, formData);
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
export const updateBrandStatus = (id) => async (dispatch) => {
  const service = new BrandService();
  try {

    console.log("sửa changeStatus", id);
    const response = await service.updateBrandStatus(id);
    console.log("response", response);
    if (response.status === 200) {
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
      const { size, totalPages, totalElements, pageable } = response.data;
      const pagination = {
        size: size,
        page: pageable.pagenumber,
        query: params.query,
        totalPages: totalPages,
        totalElements: totalElements,
      };
      dispatch({
        type: BRAND_SET_PAGEABLE,
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
      console.log("set brand")
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
