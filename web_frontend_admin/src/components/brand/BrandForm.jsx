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
import validateBrand from "../../helpers/validate/validateBrand";
import ValidateBrand from "../../helpers/validate/validateBrand";
import { min } from "moment";

class BrandForm extends Component {
  form = createRef();
  constructor(props) {
    super(props);

    this.state = {
      brand: {
        id: "",
        name: "",
        metakey: "",
        metadesc: "",
        sortOrder: 0,
        status: 0,
        logo: "",
      },
      previewImage: "",
      previewVisible: false,
    };
  }
  handelPreview = (file) => {
    console.log(file);
    if (file.thumbUrl) {
      this.state({
        ...this.state,
        previewImage: file.thumbUrl,
        previewVisible: true,
      });
    }
  };
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
    const { open, onCreate, onCancel,brands } = this.props;
    const { brand } = this.props;
    const logoUrl = brand.logo
      ? BrandService.getBrandLogoUrl(brand.logo)
      : null;
    const initialLogo = brand.logo ? { url: logoUrl, uid: brand.logo } : null;
    console.log("initialLogo", initialLogo);

    const shouldShowUpload = !brand.logo;

    return (
      <Modal
        open={open}
        title="Thêm Thương Hiệu"
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
          key={"f" + brand.id + brand.name + brand.logo +brand.metakey+brand.metadesc+brand.sortOrder+brand.status}
        >
          <Row>
            <Col md={15}>
            <Form.Item label="Mã" name="id" initialValue={brand.id} hidden>
                <Input readOnly></Input>
              </Form.Item>
              <Form.Item
                name="name"
                label="Tên thương hiệu"
                initialValue={brand.name}
                hasFeedback
                rules={
                  ValidateBrand.name
                }
              >
                <Input />
              </Form.Item>
              <Form.Item
                name="metakey"
                label="Từ khóa SEO"
                initialValue={brand.metakey}
                hasFeedback
                rules={
                  ValidateBrand.metakey
                }
              >
                
                <Input.TextArea  />
              </Form.Item>
              <Form.Item
                  name="metadesc"
                  label="Mô tả SEO"
                  initialValue={brand.metadesc}
                  hasFeedback
                  rules={ValidateBrand.metadesc}
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
                initialValue={brand.status}
                
              >
                <Select defaultValue={0}>
                  <Select.Option value={0}>Hiển thị</Select.Option>
                  <Select.Option value={1}>Ẩn đi</Select.Option>
                </Select>
              </Form.Item>
              <Form.Item label="Sắp xếp" name={'sortOrder'} initialValue={brand.sortOrder}>
                        <Select placeholder="Chọn thứ tự"
                        suffixIcon={<BsSortDownAlt /> }
                        defaultValue={0}
                        > 
                          <Select.Option value={0}
                                key={'brand_order0'}
                            >
                                Không sắp xếp
                            </Select.Option>
                          {brands&&brands.map((item)=>(
                            <Select.Option value={item.id}
                                key={'brand_order'+item.id}
                            >
                                Sau: {item.name}
                            </Select.Option>
                          ))}
                        </Select>
                    </Form.Item>
              <Form.Item
                  name="logoFile"
                  label="Logo"
                  initialValue={initialLogo ? [initialLogo] : null}
                  rules={
                    ValidateBrand.logo
                  }
                  valuePropName="fileList"
                  getValueFromEvent={this.normFile}
                  hasFeedback
                >
                  <Upload
                    listType="picture"
                    onPreview={this.handelPreview}
                    onRemove={this.handelRemove}
                    maxCount={1}
                    beforeUpload={() => false}
                  
                  >
                    <Button type="primary">Chọn Logo</Button>
                  </Upload>
                </Form.Item>
              {!shouldShowUpload && (
                <>
                  <Divider></Divider>
                  {this.state.previewVisible && (
                    <Image
                      src={this.state.previewImage}
                      style={{ width: 200 }}
                      preview={{ visible: false }}
                    ></Image>
                  )}
                </>
              )}
            </Col>
          </Row>
        </Form>
      </Modal>
    );
  }
}

export default BrandForm;
