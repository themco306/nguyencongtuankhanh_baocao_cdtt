import React, { Component } from "react";
import PropTypes from "prop-types";

import ContentHeader from "../common/ContentHeader";
import BrandList from "./BrandList";
import withRouter from "../../helpers/withRouter";
import BrandForm from "./BrandForm";
import { Button, Col, Form, Input, Modal, Pagination, Row } from "antd";
import { connect } from "react-redux";
import {
  deleteBrand,
  getBrand,
  getBrands,
  getBrandsByName,
  insertBrand,
  updateBrand,
  updateBrandStatus,
} from "../../redux/actions/brandAction";
import { current } from "@reduxjs/toolkit";
import FormItem from "antd/lib/form/FormItem";
import { setTitle } from "../../redux/actions/titleAction";

class ListBrands extends Component {
  constructor(props) {
    super(props);

    this.state = {
      open: false,
      brand: {
        id: "",
        name: "",
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
        logo: "",
      },
    };
  }
  componentDidMount = () => {
    this.props.getBrands();
    this.props.setTitle("Xem Thương Hiệu")
    console.log("did mount");
  };
  onEdit = (values) => {
    console.log("onEdit", values);
    this.setState({ ...this.state, brand: values, open: true });
  };
  onCancel = () => {
    this.setState({ ...this.state, brand: {} });
  };
  onCreate = (values) => {
    console.log("onCreat", values);
    if (values.id) {
      this.props.updateBrand(values);
    } else {
      this.props.insertBrand(values);
    }

    this.setState({ ...this.state, brand: {}, open: false });
  };
  deleteBrand = () => {
    this.props.deleteBrand(this.state.brand.id);
    console.log("delete brand");
    this.onCancel()
  };
  handleChangeStatus=(id)=>{
    this.props.updateBrandStatus(id)
  }
  onDeleteConfirm = (brand) => {
    this.setState({ ...this.state, brand: brand });
    const message = "Bạn có thật sự muốn xóa " + brand.name;
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
  // onshowSizeChanger=(current,pageSize)=>{
  //     console.log(current,pageSize)
  //     const {pagination}=this.props
  //   const params={
  //     query:pagination.query,
  //     page:0,
  //     size:pageSize
  //     }
  //     this.props.getBrandsByName(params)
  // }
  // onshowQuickJumper=(pageNumber)=>{
  //   const {pagination}=this.props
  //   const params={
  //     query:pagination.query,
  //     page:pageNumber-1,
  //     size:pagination.size
  //     }
  //     this.props.getBrandsByName(params)
  // }
  onChange=(pageNumber,pageSize)=>{
    const {pagination}=this.props
    const params={
      query:pagination.query,
      page:pageNumber-1,
      size:pageSize
      }
      this.props.getBrandsByName(params)
  }
  handleSearch=(value)=>{
    console.log("page",value)
    const {pagination}=this.props
    const params={
      query:value.query,
      size:pagination.size
      }
      this.props.getBrandsByName(params)
  }
  render() {
    const { navigate } = this.props.router;
    const { open } = this.state;
    const { brands,pagination,title } = this.props;
    
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
              initialValue={pagination.query}>
                <Input></Input>
              </Form.Item>
              <Button type="primary" htmlType="submit">Tìm</Button>
              
            </Form>
          </Col>
          <Col md={6}>
            <Button
              type="primary"
              onClick={() => {
                this.setState({ ...this.state, open: true });
              }}
            >
              Thêm thương hiệu
            </Button>
          </Col>
        </Row>
        <BrandList
          dataSource={brands}
          onDeleteConfirm={this.onDeleteConfirm}
          onEdit={this.onEdit}
          handleChangeStatus={this.handleChangeStatus}
        />
        <Row style={{ marginTop:8 }}>
          <Col md={24} style={{ textAlign:"right" }}>
          <Pagination
         
          total={pagination.totalElements}
          defaultCurrent={pagination.page}
          defaultPageSize={pagination.size}
          // showSizeChanger={this.onshowSizeChanger}
          // showQuickJumper={this.onshowQuickJumper}
          onChange={this.onChange}
          showTotal={(total) => `Tổng ${total} .`}
          
        />
          </Col>
        </Row>
        

        <BrandForm
          brand={this.state.brand}
          brands={brands}
          open={open}
          onCreate={this.onCreate}
          onCancel={() => {
            this.setState({ ...this.state, brand: {}, open: false });
          }}
        />
      </>
    );
  }
}

const mapStateToProps = (state) => ({
  brands: state.brandReducer.brands,
  pagination:state.brandReducer.pagination,
  title:state.titleReducer.title,
});

const mapDispatchToProps = {
  setTitle:setTitle,
  insertBrand: insertBrand,
  getBrands: getBrands,
  getBrand: getBrand,
  deleteBrand: deleteBrand,
  updateBrand: updateBrand,
  getBrandsByName:getBrandsByName,
  updateBrandStatus:updateBrandStatus,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(ListBrands));
