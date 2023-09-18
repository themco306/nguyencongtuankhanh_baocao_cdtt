import { TbMathGreater } from "react-icons/tb";
import { AiOutlineEdit } from "react-icons/ai";
import { BiTrashAlt } from "react-icons/bi";
import React, { Component } from "react";
import withRouter from "../../helpers/withRouter";
import { PageHeader } from "@ant-design/pro-layout";
import { Button, Divider, Modal, Skeleton, Space, Table, Tag } from "antd";
import ContentHeader from "../common/ContentHeader";
import Column from "antd/lib/table/Column";
import "../../css/CustomButton.css";
import { connect } from "react-redux";
import { clearCategory, deleteCategory, getCategories } from "../../redux/actions/categoryAction";
import { setTitle } from "../../redux/actions/titleAction";
class ListCategory extends Component {
  constructor() {
    super();
   
    this.state = {
      // dataSource: [
      //   {
      //     categoryId: 1,
      //     categoryName: "tktkt",
      //     categoryImage: "image.jpg",
      //     description: "mô tả nè",
      //     status: 0,
      //   },
      //   {
      //     categoryId: 2,
      //     categoryName: "tdktkt",
      //     categoryImage: "image1.jpg",
      //     description: "mô tả nè 4",
      //     status: 1,
      //   },
      //   {
      //     categoryId: 3,
      //     categoryName: "tkt33t",
      //     categoryImage: "imag3e.jpg",
      //     description: "mô tả nè3",
      //     status: 0,
      //   },
      // ],
      category:{

      }
    };

  }
  componentDidMount =()=>{
    this.props.getCategories();
    this.props.setTitle("Xem Danh Mục")
    console.log("did mount")
  }
  componentWillUnmount=()=>{
    this.props.clearCategory();
    console.log('will unmount')
  }
  editCategory =(category) => {
    const {navigate}=this.props.router
    navigate("/categories/update/"+category.id)
    

    
  }
  deleteCategory=()=>{
    this.props.deleteCategory(this.state.category.id)
  }
  openDeleteConfirmModal =(category)=>{

    this.setState({...this.state,category:category})
    
    const message="Bạn có thật sự muốn xóa "+category.name
    Modal.confirm({
      title:"Xác nhận!",
      content:`${message}`,
      icon:"",
      onOk:this.deleteCategory,
      okText:'Xóa',
      cancelText:'Trở lại'
    })
  }
  render() {
    const {categories,isLoading,title} =this.props
    const { navigate } = this.props.router;
    if(isLoading){
      return (<>
      <ContentHeader
          navigate={navigate}
          title={title}
          className="site-page-header"
        ></ContentHeader>
      <Skeleton active/></>)
    }
    return (
      <>
        <ContentHeader
          navigate={navigate}
          title={title}
          className="site-page-header"
        ></ContentHeader>
        <Table
          dataSource={categories}
          size="small"
          rowKey="id"
        >
          <Column
            title="Mã"
            key="id"
            dataIndex="id"
            width="5%"
            align="center"
            sorter={(a, b) => a.id - b.id}
          ></Column>

          <Column
            title="Tên danh mục"
            key="name"
            dataIndex={"name"}
            width={"20%"}
            align="center"
            sorter={(a,b)=>a.name.localeCompare(b.name) }
          ></Column>
          <Column
            title="Hình ảnh"
            key="categoryImage"
            dataIndex={"categoryImage"}
            width={"15%"}
            align="center"
          ></Column>
          <Column
            title="Mô tả"
            key="description"
            dataIndex={"description"}
            width={"30%"}
            align="center"
          ></Column>
          <Column
            title="Trạng thái"
            key="status"
            dataIndex={"status"}
            width={"10%"}
            align="center"
            sorter={(a, b) => a.status - b.status}
            render={(_, { status }) => {
              let color = "green";
              let name = "Hiển thị";
              if (status === 1) {
                color = "volcano";
                name = "Ẩn đi";
              }
              return <Tag color={color}>{name}</Tag>;
            }}
          ></Column>
          <Column
            title="Chức năng"
            key="action"
            width={"20%"}
            align="center"
            render={(_, record) => (
              <Space size={"middle"}>
                <Button key={record.key}
                 size="small" danger
                 onClick={()=>{this.openDeleteConfirmModal(record)}}
                 >
                  <BiTrashAlt />
                </Button>
                <Button
                  key={record.key}
                  size="small"
                  className="custom-button-edit"
                  onClick={()=>{this.editCategory(record)}}
                >
                  <AiOutlineEdit />
                </Button>

                <Button
                  key={record.key}
                  size="small"
                  className="custom-button-show"

                >
                  <TbMathGreater />
                </Button>
              </Space>
            )}
          ></Column>
        </Table>
      </>
    );
  }
}

const mapStateToProps = (state) => ({
  categories:state.categoryReducer.categories,
  isLoading:state.commonReducer.isLoading,
  title:state.titleReducer.title
})

const mapDispatchToProps = {
  setTitle,
  getCategories:getCategories,
  clearCategory:clearCategory,
  deleteCategory:deleteCategory

}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(ListCategory))
