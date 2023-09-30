import React, { Component } from 'react'
import { AiOutlineEdit } from 'react-icons/ai';
import { TbMathGreater } from 'react-icons/tb';
import { Button, Image, Space, Table, Tag, Tooltip } from 'antd';
import { BiTrashAlt } from 'react-icons/bi';
import Column from 'antd/es/table/Column';
import BrandService from '../../services/brandService';
import withRouter from '../../helpers/withRouter';
class BrandList extends Component {
  
  render() {
    const {navigate}=this.props.router
    const {dataSource,onEdit,onDeleteConfirm,handleChangeStatus} = this.props   
    return (
        <Table
        dataSource={dataSource}
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
          title="Tên danh mục"
          key="name"
          dataIndex={"name"}
          width={"30%"}
          align="center"
          sorter={(a,b)=>a.name.localeCompare(b.name) }
        ></Column>
        <Column
          title="Từ khóa SEO"
          key="metakey"
          dataIndex={"metakey"}
          width={"25%"}
          align="center"
          sorter={(a,b)=>a.metakey.localeCompare(b.metakey) }
        ></Column>
         
        <Column
          title="Trạng thái"
          key="status"
          dataIndex={"status"}
          width={"15%"}
          align="center"
          sorter={(a, b) => a.status - b.status}
          render={(_, { id, status }) => {
            let color = "green";
            let name = "Hiển thị";
            if (status === 1) {
              color = "volcano";
              name = "Ẩn đi";
            }
            return <Tooltip placement='top' title="Nhấn để thay đổi"> <Tag style={{ cursor:'pointer' }} color={color} onClick={()=>handleChangeStatus(id)}>{name}</Tag></Tooltip>
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
                onClick={()=>{onEdit(record)}}
              >
                <AiOutlineEdit />
              </Button>
              </Tooltip>

              <Tooltip placement='top' title="Nhấn để xem">
              <Button
                key={record.key}
                size="small"
                className="custom-button-show"
                onClick={()=>navigate("/brands/show/"+record.id)}
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

export default withRouter(BrandList)
