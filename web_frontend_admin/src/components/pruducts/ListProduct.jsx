import React, { Component } from 'react'
import ContentHeader from '../common/ContentHeader';
import ProductList from './ProductList';
import { Button, Col, Form, Input, Row } from 'antd';
import withRouter from '../../helpers/withRouter';
import { connect } from 'react-redux';
import { setTitle } from '../../redux/actions/titleAction';
import { getProducts } from '../../redux/actions/productAction';
// const products=[{
//     id:1,
//     name:"hat",
//     price:100,
//     discount:8,
//     status:1
// }]

 class ListProduct extends Component {
  componentDidMount =()=>{
    this.props.getProducts();
    this.props.setTitle("Xem Sản Phẩm")
    console.log("did mount")
  }
  render() {
    const { navigate } = this.props.router;
    const {products,title} = this.props
    console.log('products',products)
    return (
        <>
        <ContentHeader
          navigate={navigate}
          title={title}
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

const mapStateToProps = (state) => ({
  products:state.productReducer.products,
  isLoading:state.commonReducer.isLoading,
  title:state.titleReducer.title
})

const mapDispatchToProps = {
  setTitle:setTitle,
  getProducts:getProducts

}

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(ListProduct))