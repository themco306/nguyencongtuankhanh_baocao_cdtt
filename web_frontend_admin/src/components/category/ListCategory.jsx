import React, { Component } from "react";
import PropTypes from "prop-types";

import ContentHeader from "../common/ContentHeader";
import BrandList from "./CategoryList";
import withRouter from "../../helpers/withRouter";
import BrandForm from "./CategoryForm";
import { Button, Col, Form, Input, Modal, Pagination, Row } from "antd";
import { connect, useDispatch } from "react-redux";
import { setTitle } from "../../redux/actions/titleAction";
import { clearCategory, deleteCategory, getCategories, getCategoriesByName, getCategory, insertCategory, updateCategory, updateCategoryStatus } from "../../redux/actions/categoryAction";
import CategoryList from "./CategoryList";
import CategoryForm from "./CategoryForm";

class ListCategory extends Component {
  constructor(props) {
    super(props);

    this.state = {
      category: {
        id: "",
        name: "",
        parent_id:0,
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
        
      },
    };
  }
  componentDidMount = () => {
    this.props.getCategories();
    this.props.setTitle("Xem Thương Hiệu")
    console.log("did mount");
  };
  onEdit = (values) => {
    console.log("onEdit", values);
    this.setState({ ...this.state, category: values,open:true });
  };
  onCancel = () => {
    this.setState({ ...this.state, category: {},open:false });
  };
  onCreate = (values) => {
    
    if (values.id) {
      console.log("onUpdate", values);
      this.props.updateCategory(values);
    } else {
      console.log("onCreat", values);
      this.props.insertCategory(values);
    }

    this.setState({ ...this.state, category: {
        id: "",
        name: "",
        parent_id:0,
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
        
      },});

  };
  deleteCategory = () => {
    this.props.deleteCategory(this.state.category.id);
    console.log("delete brand");
    this.onCancel()
  };
  handleChangeStatus=(id)=>{
    this.props.updateCategoryStatus(id)
  }
  onDeleteConfirm = (category) => {
    this.setState({ ...this.state, category: category });
    const message = "Bạn có thật sự muốn xóa " + category.name;
    Modal.confirm({
      title: "Xác nhận!",
      content: `${message}`,
      icon: "",
      onOk: this.deleteCategory,
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
      this.props.getCategoriesByName(params)
  }
  handleSearch=(value)=>{
    console.log("page",value)
    const {pagination}=this.props
    const params={
      query:value.query,
      size:pagination.size
      }
      this.props.getCategoriesByName(params)
  }
  render() {
    const { navigate } = this.props.router;
    const { category,open} = this.state;
    const { categories,pagination,title} = this.props;
    // Bước 1: Sao chép danh sách categories để không ảnh hưởng đến đối tượng gốc
    const modifiedCategories = [...categories];

    // Bước 2: Nếu category đã được chỉ định, loại bỏ category này khỏi danh sách modifiedCategories
    if (category) {
      const categoryIndex = modifiedCategories.findIndex((item) => item.id === category.id);
    if (categoryIndex !== -1) {
        modifiedCategories.splice(categoryIndex, 1);
      } 
}
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
                this.setState({ ...this.state ,open:true});
              }}
            >
              Thêm danh mục
            </Button>
          </Col>
        </Row>
        <CategoryList
          dataSource={categories}
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
        

        <CategoryForm
          category={category}
          categories={modifiedCategories}
          open={open}
          onCreate={this.onCreate}
          onCancel={() => {
            this.setState({ ...this.state, category: {}, open: false });
          }}
        />
      </>
    );
  }
}

const mapStateToProps = (state) => ({
  categories: state.categoryReducer.categories,
  pagination:state.categoryReducer.pagination,
  title:state.titleReducer.title,
});

const mapDispatchToProps = {
  setTitle:setTitle,
  insertCategory: insertCategory,
  getCategories: getCategories,
  getCategory: getCategory,
  deleteCategory: deleteCategory,
  updateCategory: updateCategory,
  getCategoriesByName:getCategoriesByName,
  updateCategoryStatus:updateCategoryStatus,
  clearCategory:clearCategory
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(ListCategory));
