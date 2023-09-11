import React, { useContext, useEffect } from 'react'
import {PageTitleContext} from '../../Admin'; // Import the PageTitleContext
export default function AdminCategoryEdit() {
  const { setPageTitle, setPrePageTitle,setPrePageTitleLink } = useContext(PageTitleContext);
  useEffect(() => {
    setPageTitle("Sửa danh mục"); 
    setPrePageTitle("Danh mục");
    setPrePageTitleLink("/admin/category");
    
  }, []);
  return (
    <div>
      AdminCategoryEdit
    </div>
  )
}
