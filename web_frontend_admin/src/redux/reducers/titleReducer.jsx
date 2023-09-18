import { TITLE_SET } from "../actions/actionTypes";
  
  const initialState = {
    title:""
  };
  
  const titleReducer = (state = initialState, { type, payload }) => {
    switch (type) {
      case TITLE_SET:
        return { ...state, title: payload };
      default:
        return state;
    }
  };
  
  export default titleReducer;
  