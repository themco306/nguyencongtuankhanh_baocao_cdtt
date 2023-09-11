import React, { useContext, useEffect } from 'react'
import { Link } from 'react-router-dom'
import {PageTitleContext} from '../../Admin'; // Import the PageTitleContext
export default function AdminCategoryBox() {
  const { setPageTitle, setPrePageTitle, setPrePageTitleLink} = useContext(PageTitleContext);
  useEffect(() => {
    setPageTitle("Tất cả danh mục"); 
    setPrePageTitle("Trang chủ");
    setPrePageTitleLink("/admin");
  }, []);
  return (
    <div className="card ">
    <div className="card-header d-flex justify-content-end">
      <Link to={"/admin/category/add"}><buttonc className="btn btn-success">Thêm</buttonc></Link>
    </div>
    <div className="card-body">
    <table className="table table-striped projects">
  <thead>
    <tr>
      <th style={{width: '5%'}}>
        <input type="checkbox" />
      </th>
      <th style={{width: '5%'}}>
        STT
      </th>
      <th style={{width: '20%'}}>
        Danh Mục
      </th>
      <th style={{width: '20%'}}>
        Team Members
      </th>
      <th>
        Project Progress
      </th>
      <th style={{width: '12%'}} className="text-center">
        Trạng Thái
      </th>
      <th style={{width: '12%'}}>
        
      </th>
      <th style={{width: '5%'}}>
        ID
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td >
      <input type="checkbox" />
      </td>
      <td >
      1
      </td>
      <td>
        <a>
          AdminLTE v3
        </a>
        <br />
        <small>
          Created 01.01.2019
        </small>
      </td>
      <td>
        <ul className="list-inline">
          <li className="list-inline-item">
            <img alt="Avatar" className="table-avatar" src="../../dist/img/avatar.png" />
          </li>
          <li className="list-inline-item">
            <img alt="Avatar" className="table-avatar" src="../../dist/img/avatar2.png" />
          </li>
          <li className="list-inline-item">
            <img alt="Avatar" className="table-avatar" src="../../dist/img/avatar3.png" />
          </li>
          <li className="list-inline-item">
            <img alt="Avatar" className="table-avatar" src="../../dist/img/avatar4.png" />
          </li>
        </ul>
      </td>
      <td className="project_progress">
        <div className="progress progress-sm">
          <div className="progress-bar bg-green" role="progressbar" aria-valuenow={57} aria-valuemin={0} aria-valuemax={100} style={{width: '57%'}}>
          </div>
        </div>
        <small>
          57% Complete
        </small>
      </td>
      <td className="project-state">
        <span className="badge badge-success p-2 status">Hoạt động</span>
      </td>
      <td className="project-actions ">
        <div className="text-right d-flex align-items-center justify-content-between">
          <Link to=""><i className="fas fa-trash" title='Xóa'></i></Link>&nbsp;
          <Link to="/admin/category/edit/1"><i className="fas fa-edit" title='Sửa'></i></Link>&nbsp;
          <Link to="/admin/category/1"><i className="fas fa-greater-than" title='Xem'></i></Link>&nbsp;
        </div>
      </td>
      <td>
        1
      </td>
    </tr>
    
  </tbody>
</table>

    </div>

    <div className="card-footer d-flex justify-content-end">
      <Link to={"/admin/category/add"}><buttonc className="btn btn-success">Thêm</buttonc></Link>
    </div>
  
  </div>
  )
}
