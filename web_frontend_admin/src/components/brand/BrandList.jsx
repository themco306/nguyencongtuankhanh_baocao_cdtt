import React, { Component } from 'react'
import { AiOutlineEdit } from 'react-icons/ai';
import { TbMathGreater } from 'react-icons/tb';
import { Button, Image, Space, Table, Tag } from 'antd';
import { BiTrashAlt } from 'react-icons/bi';
import Column from 'antd/es/table/Column';
import BrandService from '../../services/brandService';
class BrandList extends Component {
  
  render() {
  
    const {dataSource,onEdit,onDeleteConfirm} = this.props   
    return (
        <Table
        dataSource={dataSource}
        size="small"
        rowKey="id"
        pagination={false}
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
          title="Logo"
          key="logo"
          dataIndex={"logo"}
          width={"20%"}
          align="center"
          render={(_,record)=>(
            <Space size={'middle'}>
                <Image width={'100%'} src={BrandService.getBrandLogoUrl(record.logo)}></Image>
            </Space>
          )}
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
               onClick={()=>{onDeleteConfirm(record)}}
               >
                <BiTrashAlt />
              </Button>
              <Button
                key={record.key}
                size="small"
                className="custom-button-edit"
                onClick={()=>{onEdit(record)}}
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
    )
  }
}

export default BrandList
