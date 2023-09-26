import { Button, Divider, Form, Image, Input, Modal, Radio } from "antd";
import Upload from "antd/es/upload/Upload";
import React, { Component, createRef } from "react";
import BrandService from "../../services/brandService";

class BrandForm extends Component {
  form = createRef();
  constructor(props) {
    super(props);

    this.state = {
      brand: {
        id: "",
        name: "",
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
    const { open, onCreate, onCancel } = this.props;
    const { brand } = this.props;
    const logoUrl = brand.logo
      ? BrandService.getBrandLogoUrl(brand.logo)
      : null;
    const initialLogo = brand.logo ? { url: logoUrl, uid: brand.logo } : null;
    console.log("brand", brand);

    const shouldShowUpload = !brand.logo;

    return (
      <Modal
        open={open}
        title="Thêm Thương Hiệu"
        okText="Thêm"
        cancelText="Hủy"
        onCancel={onCancel}
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
          key={"f" + brand.id + brand.name+brand.logo}
        >
          <Form.Item name="id" label="ID" initialValue={brand.id}>
            <Input readOnly />
          </Form.Item>
          <Form.Item
            name="name"
            label="Tên thương hiệu"
            initialValue={brand.name}
            rules={null}
          >
            <Input />
          </Form.Item>

          {shouldShowUpload && (
            <Form.Item
              name="logoFile"
              label="Logo"
              initialValue={initialLogo ? [initialLogo] : null}
              rules={null}
              valuePropName="fileList"
              getValueFromEvent={this.normFile}
            >
              <Upload
                listType="picture"
                onPreview={this.handelPreview}
                onRemove={this.handelRemove}
                accept=".jpg,.png,.gif"
                maxCount={1}
                beforeUpload={() => false}
              >
                <Button type="primary">Hình ảnh</Button>
              </Upload>
            </Form.Item>
          )}

          {!shouldShowUpload && (
            <>
              <Form.Item
                name="logoFile"
                label="Logo"
                initialValue={[initialLogo]}
                rules={null}
                valuePropName="fileList"
                getValueFromEvent={this.normFile}
              >
                <Upload
                  listType="picture"
                  onPreview={this.handelPreview}
                  onRemove={this.handelRemove}
                  accept=".jpg,.png,.gif"
                  maxCount={1}
                  beforeUpload={() => false}
                >
                  <Button type="primary">Hình ảnh</Button>
                </Upload>
              </Form.Item>
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
        </Form>
      </Modal>
    );
  }
}

export default BrandForm;
