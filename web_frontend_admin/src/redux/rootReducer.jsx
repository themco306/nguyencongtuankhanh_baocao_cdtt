import { combineReducers } from "redux";
import categoryReducer from "./reducers/categoryReducer";
import commonReducer from "./reducers/commonReducer";
import titleReducer from "./reducers/titleReducer";
import brandReducer from "./reducers/brandReducer";
import productReducer from "./reducers/productReducer";

const rootReducer = combineReducers({
    titleReducer:titleReducer,
    categoryReducer,
    commonReducer:commonReducer,
    brandReducer:brandReducer,
    productReducer:productReducer
})

export default rootReducer;