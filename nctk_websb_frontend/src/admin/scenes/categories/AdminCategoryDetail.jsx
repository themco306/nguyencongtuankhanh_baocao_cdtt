import React, { useContext, useEffect } from 'react'
import {PageTitleContext} from '../../Admin'; // Import the PageTitleContext
export default function AdminCategoryDetail() {
  const { setPageTitle, setPrePageTitle,setPrePageTitleLink } = useContext(PageTitleContext);
  useEffect(() => {
    setPrePageTitle("Danh mục");
    setPageTitle("Chi tiết danh mục"); 
    setPrePageTitleLink("/admin/category");

  }, []);
  return (
    <div>
      AdminCategoryDetail
    </div>
  )
}
