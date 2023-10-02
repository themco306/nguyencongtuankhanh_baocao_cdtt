import { GiEarthAfricaEurope } from "react-icons/gi"; 
import { IoEarth } from "react-icons/io"; 

import { BsList } from "react-icons/bs"; 
import { AiOutlinePlus } from "react-icons/ai"; 
import { MdOutlineCategory } from "react-icons/md"; 
import { AiOutlineHome } from "react-icons/ai"; 


import React, { useEffect, useState } from 'react';
import './DashboardPage.css';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UploadOutlined,
  UserOutlined,
  VideoCameraOutlined,
} from '@ant-design/icons';
import { Layout, Menu, Button, theme, Row, Col, Avatar, message } from 'antd';
import { BrowserRouter, Outlet, Route, Routes, useNavigate } from "react-router-dom";
import Home from "../components/home/Home";
import AddOrEditCategory from "../components/categories/AddOrEditCategory";

import { useDispatch, useSelector } from "react-redux";
import { setError, setMessage } from "../redux/actions/commonAction";
import ListBrands from "../components/brand/ListBrands";
import UploadImage from "../components/pruducts/UploadImage";
import AddOrEditProduct from "../components/pruducts/AddOrEditProduct";
import ListProduct from "../components/pruducts/ListProduct";
import ShowBrands from "../components/brand/ShowBrands";
import ListCategory from "../components/category/ListCategory";
import ShowCategory from "../components/category/ShowCategory";
const { Header, Sider, Content } = Layout;

// const App: React.FC = () => {
//    
//     const {
//       token: { colorBgContainer },
//     } = theme.useToken();
function DashboardPage() {
    const [collapsed, setCollapsed] = useState(false);

    const navigate=useNavigate();
    const msg=useSelector((state)=>state.commonReducer.message)
    const err=useSelector((state)=>state.commonReducer.error)
    const dispatch=useDispatch();
    useEffect(()=>{
      if(msg){
        dispatch(setMessage(""))
        message.success(msg)
      }
      if(err){
        dispatch(setError(""))
        message.error(err)
      }
    },[msg,err])
  return (
  
      <Layout>
      <Sider trigger={null} collapsible collapsed={collapsed}>
        <div className="demo-logo-vertical">
          <h2>{collapsed?"TS":"THEM SHOP"}</h2>
        </div>

        
        
        <Menu
          theme="dark"
          mode="inline"
          defaultSelectedKeys={['1']}
          items={[
            {
              key: '1',
              icon: <AiOutlineHome />,
              label: 'Trang chủ ',
              onClick:()=>navigate("/"),
            },
            {
              key: '2',
              icon: <MdOutlineCategory />,
              label: 'Danh mục',
              children:[
              {
                key: '21',
                icon: <BsList />,
                label: 'Tất cả danh mục',
                onClick:()=>navigate("/categories/list"),

              },
            ]
            },

            {
              key: '3',
              icon: <UploadOutlined />,
              label: 'Sản phẩm',
              children:[{
                key: '31',
                icon: <BsList />,
                label: 'Tất cả sản phẩm',
                onClick:()=>navigate("/products/list"),
              },
              {
                key: '32',
                
                icon: <AiOutlinePlus />,
                label: 'Thêm sản phẩm',
                onClick:()=>navigate("/products/add"),

              },
            ]
            },
            {
              key: '4',
              icon: <GiEarthAfricaEurope />,
              label: 'Thương hiệu',
              children:[
              {
                key: '42',
                icon: <BsList />,
                label: 'Tất cả thương hiệu',
                onClick:()=>navigate("/brands/list"),

              },
            ]
            },
          ]}
        />
      </Sider>
      <Layout>
        <Header className='site-layput-background' style={{ padding: 0 }}>
            <Row>
                <Col md={18}>
                <Button
            type="text"
            icon={collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}
            onClick={() => setCollapsed(!collapsed)}
            style={{
              fontSize: '16px',
              width: 64,
              height: 64,
            }}
          />
                </Col>
                <Col md={6} style={{display: 'flex', justifyContent: 'flex-end'}}>
                    <div style={{ padding:"10px" }}>
                        <Avatar  size='default' icon={<UserOutlined/>}>
                        
                        </Avatar>
                        Them TK
                    </div>
                </Col>
            </Row>
          
        </Header>
        <Content className='site-layput-background'
          style={{
            margin: '24px 16px',
            padding: 24,
            minHeight: 280,
            // background: colorBgContainer,
          }}
        >
          <div className="content-panel">
          <Routes>
            <Route path='/' element={<Home />}></Route>
            <Route path='/categories/add' element={<AddOrEditCategory key='add'/>}></Route>
            <Route path='/categories/list' element={<ListCategory />}></Route>
            <Route path='/categories/update/:id' element={<AddOrEditCategory key='upd' />}></Route>
            <Route path='/categories/show/:id' element={<ShowCategory key='show' />}></Route>

            <Route path='/brands/list' element={<ListBrands />}></Route>
            <Route path='/brands/show/:id' element={<ShowBrands />}></Route>

            <Route path='/products/upload' element={<UploadImage />}></Route>
            <Route path='/products/add' element={<AddOrEditProduct />}></Route>
            <Route path='/products/list' element={<ListProduct />}></Route>
          </Routes>
          <Outlet>
              
          </Outlet>
          </div>
        </Content>
      </Layout>
      </Layout>
   
  )
}

export default DashboardPage







