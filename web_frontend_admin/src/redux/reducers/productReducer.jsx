import { PRODUCTS_SET, PRODUCT_APPEND, PRODUCT_SET } from "../actions/actionTypes";

const initialState = {
  product: {},
  products: [],
  pagination:{
    size:5,
    page:0,
    totalElement:0,
    query:'',
    totalPages:1
  }
};

const productReducer = (state = initialState, { type, payload }) => {
  switch (type) {
    case PRODUCT_SET:
      return { ...state, product: payload };
    case PRODUCTS_SET:
      return { ...state, products: payload };
    // case BRAND_UPDATE:
    //   const newBrands = state.brands.filter((item) => item.id !== payload.id);
    //   return { ...state, brands: [ payload, ...newBrands ] };
    // case BRAND_DELETE:
    //   return {
    //     ...state,
    //     brands: state.brands.filter((item) => item.id !== payload),
    //   };
    case PRODUCT_APPEND:
      return { ...state, products: [payload, ...state.products] };
    //   case BRAND_SET_PAGEABLE:
    //     return { ...state, pagination:payload };
    default:
      return state;
  }
};
export default productReducer;
