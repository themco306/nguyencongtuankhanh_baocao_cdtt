import { combineReducers } from "redux";
import categoryReducer from "./reducers/categoryReducer";
import commonReducer from "./reducers/commonReducer";
import titleReducer from "./reducers/titleReducer";
import brandReducer from "./reducers/brandReducer";

const rootReducer = combineReducers({
    titleReducer:titleReducer,
    categoryReducer,
    commonReducer:commonReducer,
    brandReducer:brandReducer,
    
})

export default rootReducer;