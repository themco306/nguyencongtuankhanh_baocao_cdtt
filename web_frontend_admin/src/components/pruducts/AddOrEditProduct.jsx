import { IoSaveOutline } from "react-icons/io"; 

import { AiOutlineSave } from "react-icons/ai"; 

import React, { Component, useState } from 'react'
import ContentHeader from '../common/ContentHeader'
import withRouter from '../../helpers/withRouter'
import { Button, Col, Divider, Row, Space, Steps, message, notification } from 'antd'
import ProductForm from './ProductForm'
import UploadImage from './UploadImage'
import CategoryService from "../../services/categoryService";
import BrandService from "../../services/brandService";
import { connect } from "react-redux";
import ProductService from "../../services/productService";
import { insertProduct } from "../../redux/actions/productAction";

class AddOrEditProduct extends Component {
    
    constructor(props) {
      super(props)
    
      this.state = {
        steps : [
            {
              title: 'Thông tin cơ bản',
              description: 'Điền thông tin cơ bản',
            },
            {
              title: 'Hình ảnh',
              description: 'Chọn hình ảnh',
            }
          ],
          current:0,
          product:{

          },
          productImages:[],
          updatedProductImages:[],
          categories:[],
          brands:[]
          

      }
      
    }
    goNext=(values)=>{
        this.setState({...this.state,product:values,current:1})
    }
    goPrevious=()=>{
        this.setState({...this.state,current:0})
    }
    onUpdateFileList=(fileList)=>{
      console.log("updated fileList",fileList)

      this.setState({...this.state,updatedProductImages:fileList})
    }
    static getDerivedStateFromProps(nextProps,preState){
      if(nextProps.product&&nextProps.product.images&&nextProps.product.images.length>0){
        let productImages=[]
        if(nextProps.product.images){
          productImages=nextProps.product.images.map((item)=>({
            ...item,
            uid:item.id,
            url:ProductService.getProductImageUrl(item.fileName),
            status:"done"
          }))
        }
        return {...preState,productImages:productImages}
      }
      return null
    }
    saveProduct=()=>{
      const {product,productImages,updatedProductImages} = this.state   
      console.log("save product")
      const newProduct={
        ...product,
        images:updatedProductImages&&updatedProductImages.length>0? updatedProductImages.map(item=>{
          if(item.id){
            return {...item}
          }
          return item.response
        }):productImages.map(item=>{
          if(item.id){
            return {...item}
          }
          return item.response
        })
      }
      console.log(newProduct)
      if(newProduct.images&&newProduct.images.length>0){
        const uploading=newProduct.images.filter(item=>item.status!=='done')
        if(uploading&&uploading.length>0){
          notification.error({
            message:'Error',
            description:`Hình đang được tải lên. Vui lòng đợi!!`,
            duration:10
          })
          return
        }
      }else if(newProduct.images.length===0){
       
          notification.error({
            message:'Error',
            description:`Hình chưa được chọn. Vui lòng chọn trước khi lưu!!`,
            duration:10
          })
          return
      }
      const {navigate} = this.props.router
      this.setState({...this.state,product:{},productImages:[]})
      this.props.insertProduct(newProduct,navigate)
    }
    componentDidMount=()=>{
        this.loadData();
    }
    loadData = async() => {
      try {
        const categoryService= new CategoryService()
        const categoryResponse= await categoryService.getCategories()

        const brandService= new BrandService()
        const brandResponse= await brandService.getBrands()

        this.setState({
            ...this.state,
            categories:categoryResponse.data,
            brands:brandResponse.data
        })
      } catch (e) {
        console.log(e)
        message.error("Erro:" +e)
      }
    }
    
  render() {
    const {navigate} = this.props.router
    const {steps,current,categories,brands,productImages} = this.state
    const {product}=this.props
    const items = steps.map((item) => ({
        key: item.title,
        title: item.title,
        description:item.description
      }));
    return (
      <>
        <ContentHeader
          navigate={navigate}
          title={"title"}
          className="site-page-header"
        ></ContentHeader> 
        <Row>
            <Col md={24}>
                <Steps current={current} items={items}>
                </Steps>
            </Col>
        </Row>
        <Row>
            <Col md={24}>
                {current===0&&(<>
                <Divider></Divider>
                <ProductForm product={{  }} goNext={this.goNext} categories={categories} brands={brands}></ProductForm>
                </>)}
                {current===1&&(<>
                <Divider></Divider>
                <Row>
                    <Col span={24}>
                    <UploadImage onUpdateFileList={this.onUpdateFileList}
                    fileList={productImages}  
                    ></UploadImage>
                <Divider></Divider>
                    <div>
                        <Space>
                            <Button type='primary' 
                            onClick={this.goPrevious}>
                               Trở về
                            </Button>
                            <Button type='primary'
                            onClick={this.saveProduct}
                            icon={<AiOutlineSave />}
                            >
                               
                               {product&&product.id?'Cập nhật':'Lưu'}
                            </Button>
                        </Space>
                    </div>
                    </Col>
                </Row>

                </>)}
            </Col>
        </Row>
      </>
    )
  }
}


const mapStateToProps = (state) => ({
  product:state.productReducer.product
})

const mapDispatchToProps = {
    insertProduct:insertProduct
}

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(AddOrEditProduct))
