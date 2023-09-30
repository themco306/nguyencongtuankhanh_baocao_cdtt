import {
  CATEGORIES_SET,
  CATEGORY_DELETE,
  CATEGORY_SET,
  CATEGORY_STATE_CLEAR,
  CATEGORY_UPDATE,
} from "../actions/actionTypes";

const initialState = {
  category: {},
  categories: [],
  pagination:{
    size:5,
    page:0,
    totalElement:0,
    query:'',
    totalPages:1
  }
};

const categoryReducer = (state = initialState, { type, payload }) => {
  switch (type) {
    case CATEGORY_SET:
      return { ...state, category: payload };
    case CATEGORIES_SET:
      return { ...state, categories: payload };
      case CATEGORY_UPDATE:
      const newCategories = state.categories.filter((item) => item.id !== payload.id);
      return { ...state, categories: [ payload, ...newCategories ] };
      case CATEGORY_DELETE:
      return { ...state, categories: state.categories.filter(item=>item.id!==payload) };
    case CATEGORY_STATE_CLEAR:
      return { category: {}, categories: [] };
    default:
      return state;
  }
};

export default categoryReducer;
