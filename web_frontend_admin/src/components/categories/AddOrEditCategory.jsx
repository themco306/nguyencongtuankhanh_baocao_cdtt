import React, { Component } from "react";
import withRouter from "../../helpers/withRouter";
import { PageHeader } from "@ant-design/pro-layout";
import {
  Col,
  Divider,
  Row,
  Form,
  Input,
  Select,
  Button,
  Popconfirm,
} from "antd";
import { validateCategoryName } from "../../helpers/validate/Category";
import ContentHeader from "../common/ContentHeader";
import { connect } from "react-redux";
import {
  clearCategory,
  getCategory,

  insertCategory,

  updateCategory,
} from "../../redux/actions/categoryAction";
import { setTitle } from "../../redux/actions/titleAction";


class AddOrEditCategory extends Component {
  formref=React.createRef()
  
  constructor(props) {
    super(props);
    
    this.state = {
      category: {
        id: "",
        name: "",
        status: 0,
      },
    };
    
  }
  componentDidMount = () => {
    const { id } = this.props.router.params;
    if (id) {
      this.props.setTitle("Sửa Danh Mục")
      
      this.props.getCategory(id);
    } else {
      this.props.setTitle("Thêm Danh Mục")

      this.props.clearCategory();
    }
  };
  componentDidUpdate(prevProps) {
    if (this.props.category !== prevProps.category) {
      this.setState({
        category: this.props.category,
      });
    }
    
  }
  comfirmUpdate=()=>{
    console.log("update category")
    this.formref.current.submit();
  }
  onSubmitForm = (value) => {
    console.log(value);
    const { navigate } = this.props.router;
    const { id } = this.state.category;
    if (!id) {
      this.props.insertCategory(value, navigate);
    } else {
      this.props.updateCategory(id, value, navigate);
    }
  };

  render() {
    const { navigate } = this.props.router;
    const { isLoading,title } = this.props;
    const { category } = this.state;
    return (
      <>
        <ContentHeader
          navigate={navigate}
          title={title}
          className="site-page-header"
        ></ContentHeader>
        <Form
          layout="vertical"
          className="form"
          onFinish={this.onSubmitForm}
          key={category.id}
          ref={this.formref}
          disabled={isLoading}
        >
          <Row>
            <Col md={12}>
              <Form.Item label="Mã" name="id" initialValue={category.id}>
                <Input readOnly></Input>
              </Form.Item>
              <Form.Item
                label="Tên danh mục"
                name="name"
                rules={validateCategoryName}
                initialValue={category.name}
              >
                <Input></Input>
              </Form.Item>
              <Form.Item
                label="Trạng thái"
                name="status"
                initialValue={category.status}
              >
                <Select>
                  <Select.Option value={0}>Hiển thị</Select.Option>
                  <Select.Option value={1}>Ẩn đi</Select.Option>
                </Select>
              </Form.Item>
              <Divider></Divider>
              {!category.id && (
                <Button
                  htmlType="submit"
                  type="primary"
                  style={{ float: "right" }}
                  loading={isLoading}
                >
                  Lưu
                </Button>
              )}
              {category.id && (
                <Popconfirm title="Bạn có muốn thay đổi ?"
                onConfirm={this.comfirmUpdate}
                okText='Đồng ý' 
                cancelText='Hủy'
                >
                  <Button
                    
                    type="primary"
                    style={{ float: "right" }}
                    loading={isLoading}
                  >
                    Sửa
                  </Button>
                </Popconfirm>
              )}
            </Col>
          </Row>
        </Form>
      </>
    );
  }
}

const mapStateToProps = (state) => ({
  category: state.categoryReducer.category,
  isLoading: state.commonReducer.isLoading,
  title:state.titleReducer.title,
});

const mapDispatchToProps = {
  setTitle:setTitle,
  insertCategory: insertCategory,
  getCategory: getCategory,
  clearCategory: clearCategory,
  updateCategory: updateCategory,
};

export default withRouter(
  connect(mapStateToProps, mapDispatchToProps)(AddOrEditCategory)
);
