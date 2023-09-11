import React, { useContext, useEffect } from 'react'
import {PageTitleContext} from '../../Admin'; // Import the PageTitleContext

export default function AdminCategoryAdd() {
  const { setPageTitle, setPrePageTitle, setPrePageTitleLink } = useContext(PageTitleContext);
  useEffect(() => {
    setPageTitle("Thêm danh mục"); 
    setPrePageTitle("Danh mục");
    setPrePageTitleLink("/admin/category")
  }, []);
  return (
    <div>
      AdminCategoryAdd
    </div>
  )
}
