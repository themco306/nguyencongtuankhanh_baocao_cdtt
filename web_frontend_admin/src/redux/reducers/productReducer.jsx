import { PRODUCTS_SET, PRODUCT_APPEND, PRODUCT_DELETE, PRODUCT_SET, PRODUCT_SET_PAGEABLE, PRODUCT_STATE_CLEAR, PRODUCT_UPDATE } from "../actions/actionTypes";

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
    case PRODUCT_UPDATE:
        const updatedProduct = payload;
        const updatedProducts = state.products.map((product) => {
          if (product.id === updatedProduct.id) {
            return updatedProduct;
          }
          return product;
        });
        return { ...state, products: updatedProducts };
    case PRODUCT_DELETE:
      return {
        ...state,
        products: state.products.filter((item) => item.id !== payload),
      };
    case PRODUCT_APPEND:
      return { ...state, products: [payload, ...state.products] };
      case PRODUCT_SET_PAGEABLE:
        return { ...state, pagination:payload };
        case PRODUCT_STATE_CLEAR:
      return { ...state, product:  payload };
    default:
      return state;
  }
};
export default productReducer;
