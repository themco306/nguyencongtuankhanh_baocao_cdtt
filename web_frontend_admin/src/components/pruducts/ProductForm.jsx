import { TbBrandSafari } from "react-icons/tb";
import { MdOutlineCategory } from "react-icons/md";
import { AiOutlineUpload } from "react-icons/ai";
import {
  Button,
  Checkbox,
  Col,
  DatePicker,
  Divider,
  Form,
  Image,
  Input,
  InputNumber,
  Row,
  Select,
  Space,
  Upload,
  message,
} from "antd";
import React, { Component } from "react";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import BrandService from "../../services/brandService";
import ProductService from "../../services/productService";
class ProductForm extends Component {
  form = React.createRef();
  constructor(props) {
    super(props);

    this.state = {
      descriptionCKData: "",
    };
  }
  componentDidMount = () => {
    this.setState({
      ...this.state,
      descriptionCKData: this.props.product.description,
    });
  };
  static getDetivedStateFromProps(nextProps, preState) {
    if (nextProps.product.description && !preState.descriptionCKData) {
      return {
        ...preState,
        descriptionCKData: nextProps.product.description,
      };
    }
    return null;
  }
  goNext = () => {
    this.form.current
      .validateFields()
      .then((values) => {
        const newValues = {
          ...values,
          description: this.state.descriptionCKData,
          manufacture_date: values.manufacture_date.format("YYYY-MM-DD"),
          image: values.image[0].fileName
            ? values.iamge[0]
            : values.image[0].response,
        };
        console.log(newValues);
        this.props.goNext(newValues);
      })
      .catch((info) => {
        console.log(info);
        message.error("Dữ liệu bạn nhập có vấn đề. Vui lòng kiểm tra lại");
      });
  };
  handleImageRemoved = (info) => {
    console.log("removed");
    if (info.fileName) {
      ProductService.deleteProductImage(info.fileName);
    } else if (info.response && info.response.fileName) {
      ProductService.deleteProductImage(info.response.fileName);
    }
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
    const { product, categories, brands } = this.props;
    const { descriptionCKData } = this.state;
    return (
      <>
        <Form layout="vertical" className="form" size="middle" ref={this.form}>
          <Row>
            <Col md={12}>
              <Form.Item
                label="Tên sản phẩm"
                name={"name"}
                initialValue={product.name}
                rules={[
                  {
                    required: true,
                    min: 3,
                  },
                ]}
                hasFeedback
              >
                <Input></Input>
              </Form.Item>
              <Form.Item
                label="Giá"
                name={"price"}
                initialValue={product.price}
              >
                <InputNumber
                  min={0}
                  addonAfter={"VND"}
                  formatter={(value) =>
                    `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                  }
                  parser={(value) => value.replace(/$\s?|(,*)/g, "")}
                  style={{ width: "100%" }}
                  step={1000}
                ></InputNumber>
              </Form.Item>
              <Row>
                <Col md={12}>
                  <Form.Item
                    label="Sản phẩm nổi bật"
                    name={"is_featured"}
                    initialValue={product.is_featured}
                    valuePropName="checked"
                  >
                    <Checkbox></Checkbox>
                  </Form.Item>
                </Col>
                <Col md={12}>
                  <Form.Item
                    label="Ngày sản xuất"
                    name={"manufacture_date"}
                    initialValue={product.manufacture_date}
                  >
                    <DatePicker></DatePicker>
                  </Form.Item>
                </Col>
              </Row>
              <Form.Item
                label="Từ khóa SEO"
                name={"metakey"}
                initialValue={product.metakey}
                rules={[
                  {
                    required: true,
                    min: 3,
                  },
                ]}
                hasFeedback
              >
                <Input></Input>
              </Form.Item>
              <Form.Item
                label="Mô tả SEO"
                name={"metadesc"}
                initialValue={product.metadesc}
                rules={[
                  {
                    required: true,
                    min: 3,
                  },
                ]}
                hasFeedback
              >
                <Input></Input>
              </Form.Item>
            </Col>
            <Col md={1}>
              <Divider type="vertical" style={{ height: "100%" }}></Divider>
            </Col>
            <Col md={11}>
              <Form.Item
                label="Trạng thái"
                name={"status"}
                initialValue={product.status}
              >
                <Select placeholder="Chọn trạng thái ">
                  <Select.Option value={0}>Còn hàng</Select.Option>
                  <Select.Option value={1}>Hết hàng</Select.Option>
                </Select>
              </Form.Item>
              <Form.Item
                label="Danh mục"
                name={"category_id"}
                initialValue={product.category_id}
              >
                <Select
                  placeholder="Chọn danh mục "
                  suffixIcon={<MdOutlineCategory />}
                >
                  {categories &&
                    categories.map((item) => (
                      <Select.Option value={item.id} key={"cate" + item.id}>
                        {item.name}
                      </Select.Option>
                    ))}
                </Select>
              </Form.Item>
              <Form.Item
                label="Thương hiệu"
                name={"brand_id"}
                initialValue={product.brand_id}
              >
                <Select
                  placeholder="Chọn thương hiệu "
                  suffixIcon={<TbBrandSafari />}
                >
                  {brands &&
                    brands.map((item) => (
                      <Select.Option value={item.id} key={"brand" + item.id}>
                        <Space>
                          <Image
                            src={BrandService.getBrandLogoUrl(item.logo)}
                            height={32}
                          ></Image>
                          {item.name}
                        </Space>
                      </Select.Option>
                    ))}
                </Select>
              </Form.Item>

              <Form.Item
                label="Ảnh chính"
                name={"image"}
                initialValue={
                  product.image
                    ? [
                        {
                          ...product.image,
                          url: ProductService.getProductImageUrl(
                            product.image.fileName
                          ),
                        },
                      ]
                    : []
                }
                valuePropName="fileList"
                getValueFromEvent={this.normFile}
              >
                <Upload
                  listType="picture"
                  accept=".jpg,.png,.gif"
                  maxCount={1}
                  onRemove={this.handleImageRemoved}
                  action={ProductService.getProductImageUploadUrl()}
                >
                  <Button icon={<AiOutlineUpload />}></Button>
                </Upload>
              </Form.Item>
            </Col>
          </Row>
          <Row>
            <Col md={24}>
              <Form.Item
                label="Chi tiết"
                name={"detail"}
                initialValue={product.detail}
              >
                <ReactQuill theme="snow"></ReactQuill>
              </Form.Item>
            </Col>
          </Row>
          <Row>
            <Col md={24}>
              <Form.Item
                label="Mô tả"
                name={"description"}
                initialValue={descriptionCKData}
              >
                <CKEditor
                  editor={ClassicEditor}
                  data={descriptionCKData}
                  onReady={(editor) => {
                    editor.editing.view.change((writer) => {
                      writer.setStyle(
                        "height",
                        "200px",
                        editor.editing.view.document.getRoot()
                      );
                    });
                  }}
                  onChange={(e, editor) => {
                    const data = editor.getData();
                    this.setState({ ...this.state, descriptionCKData: data });
                  }}
                ></CKEditor>
              </Form.Item>
            </Col>
          </Row>
          <Row>
            <Col md={24}>
              <Divider></Divider>
              <Button
                type="primary"
                onClick={this.goNext}
                style={{ float: "right" }}
              >
                Tiếp
              </Button>
            </Col>
          </Row>
        </Form>
      </>
    );
  }
}

export default ProductForm;
