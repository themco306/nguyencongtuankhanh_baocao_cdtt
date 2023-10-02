import React, { Component } from 'react'
import ContentHeader from '../common/ContentHeader'
import withRouter from '../../helpers/withRouter'
import { connect } from 'react-redux';
import { setTitle } from '../../redux/actions/titleAction';
import { Badge, Descriptions, Image } from 'antd';

import CategoryService from '../../services/categoryService';
import { getCategory } from '../../redux/actions/categoryAction';

 class ShowCatgory extends Component {
    componentDidMount=()=>{
        this.props.setTitle("Chi Tiết Danh mục")
        const { id } = this.props.router.params;
      
        this.props.getCategory(id);
        
    }
    constructor(props) {
        super(props);
        
        this.state = {
        };
    }
    
  render() {
    const {category} = this.props
    console.log("categoryshow",category)
    const {navigate}=this.props.router
    const {title } = this.props
   
    return (
      <>
         <ContentHeader
          navigate={navigate}
          title={title}
          className="site-page-header"
        ></ContentHeader>
        
        <Descriptions title="Thông tin danh mục" bordered
                            labelStyle={{ width: '15%' }}
                            column={24}
        >
            <Descriptions.Item label="ID"
                span={8}
                
            >
                {category.id}
            </Descriptions.Item>
            <Descriptions.Item label="Tên"
                span={16}
                
            >
                {category.name}
            </Descriptions.Item>
            <Descriptions.Item label="Trạng thái"
            span={8}
          

            >
                {category.status&&category.status===0?'Hiển thị':'Ẩn đi'}
            </Descriptions.Item>
            <Descriptions.Item label="Danh mục cha"
                 span={8}
                style={{ width:"15%" }}
            >
              {category.parentName!==""?category.parentName:"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Sắp xếp"
            span={8}
            >
                Sau: {category.sortOrderName!==""?category.sortOrderName:"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Từ khóa SEO"
            span={24}
           

            >
                {category.metakey}
            </Descriptions.Item>
            
            
            <Descriptions.Item label="Mô tả SEO"
            span={24}
           

            >
                {category.metadesc}
            </Descriptions.Item>
            <Descriptions.Item label="ID người tạo"
            span={4}
            >
                {category.created_by??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Tạo vào ngày"
            span={20}
           

            >
                {category.created_at??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="ID người sửa"
            span={4}
            >
                {category.updated_by??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Sửa vào ngày"
            span={20}
            >
                {category.updated_at??"Không có"}
            </Descriptions.Item>
            
        </Descriptions>
      </>
    )
  }
}

const mapStateToProps = (state) => ({
    title:state.titleReducer.title,
    category: state.categoryReducer.category,
  });
  
  const mapDispatchToProps = {
    setTitle:setTitle,
    getCategory:getCategory
  };
  
  export default connect(
    mapStateToProps,
    mapDispatchToProps
  )(withRouter(ShowCatgory));
