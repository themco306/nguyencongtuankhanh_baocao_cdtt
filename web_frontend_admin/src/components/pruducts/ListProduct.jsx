import React, { Component } from 'react'
import ContentHeader from '../common/ContentHeader';
import ProductList from './ProductList';
import { Button, Col, Form, Input, Row } from 'antd';
import withRouter from '../../helpers/withRouter';
const products=[{
    id:1,
    name:"hat",
    price:100,
    discount:8,
    status:1
}]
export class ListProduct extends Component {
    
  render() {
    const { navigate } = this.props.router;
    return (
        <>
        <ContentHeader
          navigate={navigate}
          title={null}
          className="site-page-header"
        ></ContentHeader>
        <Row>
        <Col md={18} style={{ marginBottom:8 }}>
            <Form layout="inline" name="searchForm" onFinish={this.handleSearch}>
              <Form.Item
              name='query'
              >
                <Input></Input>
              </Form.Item>
              <Button type="primary" htmlType="submit">Tìm</Button>
              
            </Form>
          </Col>
          <Col md={6}>
            <Button
              type="primary"
              onClick={() => navigate("/product/add")}
            >
              Thêm
            </Button>
          </Col>
        </Row>
        <ProductList
          products={products}
          onDeleteConfirm={this.onDeleteConfirm}
          onEdit={this.onEdit}
        />
        
        

     
      </>
    )
  }
}

export default withRouter(ListProduct)
