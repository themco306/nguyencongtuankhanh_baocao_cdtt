import {
  CATEGORIES_SET,
  CATEGORY_APPEND,
  CATEGORY_DELETE,
  CATEGORY_GET_PARENT,
  CATEGORY_GET_SORTORDER,
  CATEGORY_SET,
  CATEGORY_STATE_CLEAR,
  CATEGORY_UPDATE,
} from "../actions/actionTypes";

const initialState = {
  category: {
    parentName:"",
    sortOrderName:""
  },
  categories: [],
  pagination: {
    size: 5,
    page: 0,
    totalElement: 0,
    query: "",
    totalPages: 1,
  },
};

const categoryReducer = (state = initialState, { type, payload }) => {
  switch (type) {
    case CATEGORY_SET:
      return { ...state, category: { ...state.category, ...payload } };
    case CATEGORIES_SET:
      return { ...state, categories: payload };
    case CATEGORY_GET_PARENT:
      return { ...state, category: { ...state.category, parentName: payload } };
    case CATEGORY_GET_SORTORDER:
      return { ...state, category: { ...state.category, sortOrderName: payload } };
      case CATEGORY_UPDATE:
        const updatedCategory = payload;
        const updatedCategories = state.categories.map((category) => {
          if (category.id === updatedCategory.id) {
            return updatedCategory;
          }
          return category;
        });
        return { ...state, categories: updatedCategories };
    case CATEGORY_DELETE:
      return { ...state, categories: state.categories.filter((item) => item.id !== payload) };
    case CATEGORY_APPEND:
      return { ...state, categories: [payload, ...state.categories] };
    case CATEGORY_STATE_CLEAR:
      return { ...state, category:  payload };
    default:
      return state;
  }
};

export default categoryReducer;