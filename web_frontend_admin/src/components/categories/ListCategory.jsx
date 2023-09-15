import { TbMathGreater } from "react-icons/tb";
import { AiOutlineEdit } from "react-icons/ai";
import { BiTrashAlt } from "react-icons/bi";
import React, { Component } from "react";
import withRouter from "../../helpers/withRouter";
import { PageHeader } from "@ant-design/pro-layout";
import { Button, Divider, Space, Table, Tag } from "antd";
import ContentHeader from "../common/ContentHeader";
import Column from "antd/lib/table/Column";
import "../../css/CustomButton.css";
class ListCategory extends Component {
  constructor() {
    super();
    this.state = {
      dataSource: [
        {
          categoryId: 1,
          categoryName: "tktkt",
          categoryImage: "image.jpg",
          description: "mô tả nè",
          status: 0,
        },
        {
          categoryId: 2,
          categoryName: "tdktkt",
          categoryImage: "image1.jpg",
          description: "mô tả nè 4",
          status: 1,
        },
        {
          categoryId: 3,
          categoryName: "tkt33t",
          categoryImage: "imag3e.jpg",
          description: "mô tả nè3",
          status: 0,
        },
      ],
    };
  }
  render() {
    const { navigate } = this.props.router;
    return (
      <>
        <ContentHeader
          navigate={navigate}
          title="Xem Danh Mục"
          className="site-page-header"
        ></ContentHeader>
        <Table
          dataSource={this.state.dataSource}
          size="small"
          rowKey="categoryId"
        >
          <Column
            title="Mã"
            key="categoryId"
            dataIndex="categoryId"
            width="5%"
            align="center"
            sorter={(a, b) => a.categoryId - b.categoryId}
          ></Column>

          <Column
            title="Tên danh mục"
            key="categoryName"
            dataIndex={"categoryName"}
            width={"20%"}
            align="center"
            sorter={(a,b)=>a.categoryName.localeCompare(b.categoryName) }
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
                <Button key={record.key} size="small" danger>
                  <BiTrashAlt />
                </Button>
                <Button
                  key={record.key}
                  size="small"
                  className="custom-button-edit"
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

export default withRouter(ListCategory);
