import React, { Component } from 'react'
import withRouter from '../../helpers/withRouter'
import { PageHeader } from '@ant-design/pro-layout'
import { Col, Divider,Row ,Form, Input, Select, Button} from 'antd';
import { validateCategoryName } from '../../helpers/validate/Category';
import ContentHeader from '../common/ContentHeader';



 class AddOrEditCategory extends Component {
  onSubmitForm =(value) => {
    console.log(value)
  }
  
  render() {
    const {navigate}=this.props.router;
    return (
      <>
        <ContentHeader navigate={navigate} title="Thêm Danh Mục" className="site-page-header"></ContentHeader>
        <Form layout='vertical' className='form' onFinish={this.onSubmitForm}>
          <Row>
            <Col md={12}>
                <Form.Item label="Mã" name="categoryId">
                    <Input readOnly></Input>
                </Form.Item>
                <Form.Item label="Tên danh mục" name="categoryName" rules={validateCategoryName}>
                  <Input></Input>
                </Form.Item>
                <Form.Item label="Trạng thái" name="status" initialValue={0}>
                  <Select >
                    <Select.Option value={0}>
                      Hiển thị
                    </Select.Option>
                    <Select.Option value={1}>
                      Ẩn đi
                    </Select.Option>
                  </Select>
                </Form.Item>
                <Divider></Divider>
                <Button htmlType='submit' type='primay' style={{ float:'right' }}>
                  Lưu
                </Button>
            </Col>
          </Row>
        </Form>
      </>
    )
  }
}

export default withRouter(AddOrEditCategory)
