import React, { Children, createContext, useEffect, useState } from 'react'
import { Link, Outlet } from 'react-router-dom'
import TopNav from './components/TopNav'
import Menu from './components/Menu'
export const PageTitleContext = createContext();
export default function Admin() { 

  const [pageTitle, setPageTitle] = useState("Trang quản lý");
  const [prePageTitle, setPrePageTitle] = useState("");
  const [prePageTitleLink, setPrePageTitleLink] = useState("/admin");

  return (
    <div className="wrapper">
      <TopNav/>
      <Menu/>
  <div className="content-wrapper" style={{minHeight: 229}}>
    {/* Content Header (Page header) */}
    <section className="content-header">
      <div className="container-fluid">
        <div className="row mb-2">
          <div className="col-sm-6">
            <h3>{pageTitle}</h3>
          </div>
          <div className="col-sm-6">
            <ol className="breadcrumb float-sm-right">
              <li className="breadcrumb-item"><Link to={prePageTitleLink}>{prePageTitle}</Link></li>
              <li className="breadcrumb-item active">{pageTitle}</li>
            </ol>
          </div>
        </div>
      </div>{/* /.container-fluid */}
    </section>
    {/* Main content */}
    <section className="content">
    <PageTitleContext.Provider value={{setPageTitle,setPrePageTitle,setPrePageTitleLink}}>
          <Outlet />
    </PageTitleContext.Provider>
    </section>
    {/* /.content */}
  </div>
  {/* /.content-wrapper */}
  <footer className="main-footer">
    <div className="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
  <div id="sidebar-overlay" /></div>

    
  )
}
