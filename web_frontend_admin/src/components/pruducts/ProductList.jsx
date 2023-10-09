import { Button, Image, Space, Table, Tag, Tooltip } from 'antd';
import Column from 'antd/lib/table/Column';
import React, { Component } from 'react'
import ProductService from '../../services/productService';
import { BiTrashAlt } from 'react-icons/bi';
import { AiOutlineEdit } from 'react-icons/ai';
import { TbMathGreater } from 'react-icons/tb';
import withRouter from '../../helpers/withRouter';

 class ProductList extends Component {
  render() {

    const {products,onEdit,onDeleteConfirm,handleChangeStatus} = this.props   
    const {navigate}=this.props.router
    return (
        <Table
        dataSource={products}
        size="small"
        rowKey="id"
        // pagination={true}
        scroll={true}
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
          title="Hình ảnh"
          key="imageFileName"
          
          width={"20%"}
          align="center"
          render={(_,record)=>(
            <Space size={'middle'}>
                {record.image && record.image.fileName ? (
        <Image
          width={'50px'}
          src={ProductService.getProductImageUrl(record.image.fileName)}
        />
      ) : (
        <Image width={'50px'} src={''} /> // Thay thế 'default-placeholder-image-url' bằng URL hình ảnh mặc định
      )}
            </Space>
          )}
        ></Column>
        <Column
          title="Tên sản phẩm"
          key="name"
          dataIndex={"name"}
          width={"20%"}
          align="center"
          sorter={(a,b)=>a.name.localeCompare(b.name) }
        ></Column>
       <Column
          title="Giá"
          key="price"
          dataIndex={"price"}
          width={"10%"}
          align="center"
          sorter={(a,b)=>a.name.localeCompare(b.name) }
        ></Column>
        <Column
          title="Số lượng"
          key="quantity"
          dataIndex={"quantity"}
          width={"10%"}
          align="center"
          sorter={(a,b)=>a.quantity.localeCompare(b.quantity) }
        ></Column>
        <Column
          title="Trạng thái"
          key="status"
          dataIndex={"status"}
          width={"10%"}
          align="center"
          sorter={(a, b) => a.status - b.status}
          render={(_, {id, status }) => {
            let color = "green";
            let name = "Hiển thị";
            if (status === 1) {
              color = "volcano";
              name = "Ẩn đi";
            }
            return  <Tooltip placement='top' title="Nhấn để thay đổi"> <Tag style={{ cursor:'pointer' }} color={color} onClick={()=>handleChangeStatus(id)}>{name}</Tag></Tooltip>;
          }}
        ></Column>
        <Column
          title="Chức năng"
          key="action"
          width={"20%"}
          align="center"
          render={(_, record) => (
            <Space size={"middle"}>
                <Tooltip placement='top' title="Nhấn để xóa">
              <Button key={record.key}
               size="small" danger
               onClick={()=>{onDeleteConfirm(record)}}
               >
                <BiTrashAlt />
              </Button>
              </Tooltip>
              <Tooltip placement='top' title="Nhấn để sửa">
              <Button
                key={record.key}
                size="small"
                className="custom-button-edit"
                onClick={()=>navigate("/products/edit/" + record.id)}
              >
                <AiOutlineEdit />
              </Button>
              </Tooltip>
              <Tooltip placement='top' title="Nhấn để xem">
              <Button
                key={record.key}
                size="small"
                className="custom-button-show"
                onClick={()=>navigate("/products/show/" + record.id)}
              >
                <TbMathGreater />
              </Button>
              </Tooltip>

            </Space>
          )}
        ></Column>
      </Table>
    )
  }
}
export default withRouter(ProductList)
