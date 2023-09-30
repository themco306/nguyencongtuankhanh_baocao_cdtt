import { BsSortDownAlt } from "react-icons/bs"; 
import {
  Button,
  Col,
  Divider,
  Form,
  Image,
  Input,
  Modal,
  Radio,
  Row,
  Select,
} from "antd";
import Upload from "antd/es/upload/Upload";
import React, { Component, createRef } from "react";
import BrandService from "../../services/brandService";

class CategoryForm extends Component {
  form = createRef();
  constructor(props) {
    super(props);

    this.state = {
      category: {
        id: "",
        name: "",
        parent_id:0,
        level:0,
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
        
      },
      previewImage: "",
      previewVisible: false,
    };
  }
  handelRemove = (value) => {
    console.log(value);
  };
  normFile = (e) => {
    if (Array.isArray(e)) {
      return e;
    }
    if (e.fileList.length > 1) {
      return [e.fileList[1]];
    }
    return e && e.fileList;
  };

  render() {
    const { open, onCreate, onCancel,categories } = this.props;
    const { category } = this.props;
   
    console.log("category", category);
    return (
      <Modal
        open={open}
        title="Thêm Danh Mục"
        okText="Thêm"
        cancelText="Hủy"
        onCancel={onCancel}
        width={'130vh'}
        onOk={() => {
          this.form.current
            .validateFields()
            .then((values) => {
              this.form.current.resetFields();
              onCreate(values);
            })
            .catch((info) => {
              console.log("Validate Failed:", info);
            });
        }}
      >
        <Form
          ref={this.form}
          layout="vertical"
          name="form_in_modal"
          initialValues={{
            modifier: "public",
          }}
          key={"f" + category.id + category.name  +category.metakey+category.metadesc+category.sortOrder+category.status+category.parent_id+category.level}
        >
          <Row>
            <Col md={15}>
            <Form.Item label="Mã" name="id" initialValue={category.id} hidden>
                <Input readOnly></Input>
              </Form.Item>
              <Form.Item
                name="name"
                label="Tên danh mục"
                initialValue={category.name}
                rules={null}
              >
                <Input />
              </Form.Item>
              <Form.Item
                name="metakey"
                label="Từ khóa SEO"
                initialValue={category.metakey}
                rules={null}
              >
                
                <Input.TextArea  />
              </Form.Item>
              <Form.Item
                  name="metadesc"
                  label="Mô tả SEO"
                  initialValue={category.metadesc}
                  rules={null}
                >
                  <Input.TextArea rows={3} />
                </Form.Item>
            </Col>
            <Col md={1}>
            <Divider type='vertical' style={{ height:'100%' }}></Divider>

            </Col>
            <Col md={8}>
            <Form.Item
                label="Trạng thái"
                name="status"
                initialValue={category.status}
              >
                <Select defaultValue={0}>
                  <Select.Option value={0}>Hiển thị</Select.Option>
                  <Select.Option value={1}>Ẩn đi</Select.Option>
                </Select>
              </Form.Item>
              <Form.Item label="Sắp xếp" name={'sortOrder'} initialValue={category.sortOrder}>
                        <Select placeholder="Chọn thứ tự"
                        suffixIcon={<BsSortDownAlt /> }
                        defaultValue={0}
                        > 
                          <Select.Option value={0}
                                key={'brand_order0'}
                            >
                                Không sắp xếp
                            </Select.Option>
                          {categories&&categories.map((item)=>(
                            <Select.Option value={item.id}
                                key={'brand_order'+item.id}
                            >
                                Sau: {item.name}
                            </Select.Option>
                          ))}
                        </Select>
                    </Form.Item>
                    <Form.Item label="Cấp cha" name={'parent_id'} initialValue={category.parent_id}>
                        <Select placeholder="Chọn cấp cha"
                        suffixIcon={<BsSortDownAlt /> }
                        defaultValue={0}
                        > 
                          <Select.Option value={0}
                                key={'brand_parent0'}
                            >
                                Không sắp xếp
                            </Select.Option>
                          {categories&&categories.map((item)=>(
                            <Select.Option value={item.id}
                                key={'brand_parent'+item.id}
                            >
                                Sau: {item.name}
                            </Select.Option>
                          ))}
                        </Select>
                    </Form.Item>
            </Col>
          </Row>
        </Form>
      </Modal>
    );
  }
}

export default CategoryForm;
