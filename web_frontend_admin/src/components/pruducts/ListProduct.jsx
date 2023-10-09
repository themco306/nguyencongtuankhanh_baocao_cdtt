import React, { Component } from 'react'
import ContentHeader from '../common/ContentHeader';
import ProductList from './ProductList';
import { Button, Col, Form, Input, Modal, Row } from 'antd';
import withRouter from '../../helpers/withRouter';
import { connect } from 'react-redux';
import { setTitle } from '../../redux/actions/titleAction';
import { deleteProduct, getProducts, getProductsByName, updateProductStatus } from '../../redux/actions/productAction';
// const products=[{
//     id:1,
//     name:"hat",
//     price:100,
//     discount:8,
//     status:1
// }]

 class ListProduct extends Component {
  constructor(props) {
    super(props);

    this.state = {
      product: {
        id: "",
        name: "",
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
   
      },
    };
  }
  componentDidMount =()=>{
    this.props.getProducts();
    this.props.setTitle("Xem Sản Phẩm")
    console.log("did mount")
  }
  deleteBrand = () => {
    this.props.deleteProduct(this.state.product.id);
    console.log("delete brand");
    this.onCancel()
  };
  handleChangeStatus=(id)=>{
    this.props.updateProductStatus(id)
  }
  onCancel = () => {
    this.setState({ ...this.state, product: {} });
  };
  onDeleteConfirm = (product) => {
    this.setState({ ...this.state, product: product });
    const message = "Bạn có thật sự muốn xóa " + product.name;
    Modal.confirm({
      title: "Xác nhận!",
      content: `${message}`,
      icon: "",
      onOk: this.deleteBrand,
      okText: "Xóa",
      cancelText: "Trở lại",
      onCancel: this.onCancel,
    });
  };
  handleSearch=(value)=>{
    console.log("page",value)
    // const {pagination}=this.props
    const params={
      query:value.query,
      size:5
      }
      this.props.getproductsByName(params)
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
              onClick={() => navigate("/products/add")}
            >
              Thêm
            </Button>
          </Col>
        </Row>
        <ProductList
          products={products}
          onDeleteConfirm={this.onDeleteConfirm}
          onEdit={this.onEdit}
          handleChangeStatus={this.handleChangeStatus}
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
  getProducts:getProducts,
  deleteProduct:deleteProduct,
  updateProductStatus:updateProductStatus,
  getproductsByName:getProductsByName

}

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(ListProduct))