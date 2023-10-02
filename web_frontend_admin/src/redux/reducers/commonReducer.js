import { COMMON_EROR_SET, COMMON_LOADING_SET, COMMON_MESSAGE_SET, COMMON_MODAL_SET } from "../actions/actionTypes";

const initialState = {
  message: "",
  error: "",
  isLoading: false,
  open:false
};

const commonReducer = (state = initialState, { type, payload }) => {
  switch (type) {
    case COMMON_MESSAGE_SET:
      return { ...state, message: payload };
    case COMMON_EROR_SET:
      return { ...state, error: payload };
    case COMMON_LOADING_SET:
      return { ...state, isLoading: payload };
      case COMMON_MODAL_SET:
        return { ...state, open: payload };
    default:
      return state;
  }
};
export default commonReducer;
