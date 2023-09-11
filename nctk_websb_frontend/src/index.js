import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import Admin from './admin/Admin';
import Store from './state/Store';

import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import Dashboard from './admin/scenes/Dashboard';
import AdminCategory from './admin/scenes/categories/AdminCategory';
import AdminCategoryBox from './admin/scenes/categories/AdminCategoryBox';
import AdminCategoryDetail from './admin/scenes/categories/AdminCategoryDetail';
import AdminCategoryAdd from './admin/scenes/categories/AdminCategoryAdd';
import AdminCategoryEdit from './admin/scenes/categories/AdminCategoryEdit';
const root = ReactDOM.createRoot(document.getElementById('root'));
const router = createBrowserRouter([
  {
    path:'/admin',
    element:<Admin/>,
    children:[
      {
        index:true,
        element: <Dashboard />
      },
      {
        path:'/admin/product',
        element:<Admin/>,
        children:[
          {
            index:true,
            element: <Admin />
          },
          {
            path:'/admin/product/page/:pageNum',
            element: <Admin />
          },
          {
            path:'/admin/product/:id',
            element: <Admin />
          },
          {
            path:'/admin/product/add',
            element:<Admin/>
          },
          {
            path:'/admin/product/edit/:id',
            element:<Admin/>
          }
        ]
      },
      {
        path:'/admin/category',
        element:<AdminCategory/>,
        children:[
          {
            index:true,
            element: <AdminCategoryBox />
          },
          {
            path:'/admin/category/page/:pageNum',
            element: <AdminCategoryBox />
          },
          {
            path:'/admin/category/:id',
            element: <AdminCategoryDetail />
          },
          {
            path:'/admin/category/add',
            element:<AdminCategoryAdd/>
          },
          {
            path:'/admin/category/edit/:id',
            element:<AdminCategoryEdit/>
          }
        ]
      },
    ]
  }
])
root.render(
  <React.StrictMode>
    <Provider store={Store}> 
   <RouterProvider router={router}>

   </RouterProvider>
   </Provider>
  </React.StrictMode>
);


