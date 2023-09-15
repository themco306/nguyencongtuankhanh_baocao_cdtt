import { BsList } from "react-icons/bs"; 
import { AiOutlinePlus } from "react-icons/ai"; 
import { MdOutlineCategory } from "react-icons/md"; 
import { AiOutlineHome } from "react-icons/ai"; 


import React, { useState } from 'react';
import './DashboardPage.css';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UploadOutlined,
  UserOutlined,
  VideoCameraOutlined,
} from '@ant-design/icons';
import { Layout, Menu, Button, theme, Row, Col, Avatar } from 'antd';
import { BrowserRouter, Outlet, Route, Routes, useNavigate } from "react-router-dom";
import Home from "../components/home/Home";
import AddOrEditCategory from "../components/categories/AddOrEditCategory";
import ListCategory from "../components/categories/ListCategory";
const { Header, Sider, Content } = Layout;

// const App: React.FC = () => {
//    
//     const {
//       token: { colorBgContainer },
//     } = theme.useToken();
function DashboardPage() {
    const [collapsed, setCollapsed] = useState(false);

    const navigate=useNavigate();
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
              children:[{
                key: '21',
                icon: <AiOutlinePlus />,
                label: 'Thêm danh mục',
                onClick:()=>navigate("/categories/add"),
              },
              {
                key: '22',
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
            <Route path='/categories/add' element={<AddOrEditCategory />}></Route>
            <Route path='/categories/list' element={<ListCategory />}></Route>
            
            
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







