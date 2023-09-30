import React, { Component } from 'react'
import ContentHeader from '../common/ContentHeader'
import withRouter from '../../helpers/withRouter'
import { connect } from 'react-redux';
import { setTitle } from '../../redux/actions/titleAction';
import { Badge, Descriptions, Image } from 'antd';
import { getBrand } from '../../redux/actions/brandAction';
import BrandService from '../../services/brandService';

 class ShowBrands extends Component {
    componentDidMount=()=>{
        this.props.setTitle("Chi Tiết Thương Hiệu")
        const { id } = this.props.router.params;
      
      this.props.getBrand(id);
    }
    constructor(props) {
        super(props);
        
        this.state = {
        };
    }
    
  render() {
    const {brand} = this.props
    console.log("brandshow",brand)
    const {navigate}=this.props.router
    const {title } = this.props
   
    return (
      <>
         <ContentHeader
          navigate={navigate}
          title={title}
          className="site-page-header"
        ></ContentHeader>
        
        <Descriptions title="Thông tin thương hiệu" bordered
                            labelStyle={{ width: '15%' }}

        >
            <Descriptions.Item label="ID"
                span={2}
                
            >
                {brand.id}
            </Descriptions.Item>
            <Descriptions.Item label="Tên"
                span={2}
                
            >
                {brand.name}
            </Descriptions.Item>
            <Descriptions.Item label="Trạng thái"
            span={2}
          

            >
                {brand.status&&brand.status===0?'Hiển thị':'Ẩn đi'}
            </Descriptions.Item>
            
            <Descriptions.Item label="Từ khóa SEO"
            span={2}
           

            >
                {brand.metakey}
            </Descriptions.Item>
            <Descriptions.Item label="Logo"
                 span={2}
                style={{ width:"15%" }}
            >
                <Image src={BrandService.getBrandLogoUrl(brand.logo)} style={{ width:"100px" }}></Image>
            </Descriptions.Item>
            <Descriptions.Item label="Mô tả SEO"
            span={3}
           

            >
                {brand.metadesc}
            </Descriptions.Item>
            <Descriptions.Item label="ID người tạo"
            span={2}
            >
                {brand.created_by??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Tạo vào ngày"
            span={2}
           

            >
                {brand.created_at??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="ID người sửa"
            span={2}
            >
                {brand.updated_by??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Sửa vào ngày"
            span={2}
            >
                {brand.updated_at??"Không có"}
            </Descriptions.Item>
            <Descriptions.Item label="Sắp xếp"
            span={2}
            >
                {brand.sortOrder??"Không có"}
            </Descriptions.Item>
        </Descriptions>
      </>
    )
  }
}

const mapStateToProps = (state) => ({
    title:state.titleReducer.title,
    brand: state.brandReducer.brand,
  });
  
  const mapDispatchToProps = {
    setTitle:setTitle,
    getBrand:getBrand
  };
  
  export default connect(
    mapStateToProps,
    mapDispatchToProps
  )(withRouter(ShowBrands));
