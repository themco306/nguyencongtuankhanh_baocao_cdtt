import { combineReducers } from "redux";
import categoryReducer from "./reducers/categoryReducer";
import commonReducer from "./reducers/commonReducer";
import titleReducer from "./reducers/titleReducer";

const rootReducer = combineReducers({
    titleReducer:titleReducer,
    categoryReducer,
    commonReducer:commonReducer,
})

export default rootReducer;