import { AiOutlinePlus } from "react-icons/ai"; 
import { Modal, Upload, message } from 'antd'
import React, { useState } from 'react'


const getBase64=(file)=>{
    new Promise((resovle,reject)=>{
        const reader=new FileReader()
        reader.readAsDataURL(file)

        reader.onload=()=> resovle(reader.result)

        reader.onerror=(error)=>reject(error)
    })
}

const UploadImage=(props)=> {
    const [previewOpen, setPreviewOpen] = useState(false)
    const [previewImage, setPreviewImage] = useState("")
    const [previewTitle, setPreviewTitle] = useState("")
    const handleCancel=()=>{
        setPreviewOpen(false)
    }
const handlePreview=async (file)=>{
    if(!file.url&& !file.preview){
        file.preview=await getBase64(file.originFileObj)
    }

    setPreviewImage(file.url||file.preview)
    setPreviewOpen(true)
    setPreviewTitle(file.name||file.url.substring(file.url.lastIndexOf("/")+1))
}
const handleChange=(info)=>{
    const {fileList}=info
    const status = info.file.status
    if(status!=='uploading'){
        console.log(info.file)

    }
    if(status==='done'){
        message.success(`File ${info.file.name} tải lên thành công!!`)
    }else if (status==='removed'){
        message.success(`File ${info.file.name} đã được xóa!!`)

    }else if (status!=="uploading"){
        message.error(`File ${info.file.name} tải lên thất bại!!`)
    }
    props.onUpdateFileList(fileList.slice())
}
const handleRemove=(info)=>{
    if(info.fileName){
        console.log("delet",info.fileName)
    }else if(info.response&& info.response.fileName){
        console.log("delete",info.response.fileName)
    }
}
    const uploadButton=(<div>
        <AiOutlinePlus />
        <div style={{ marginTop:8 }}>Thêm</div>
    </div>)
    const {fileList} = props
  return (
   <>
   <Upload name='file' 
   action={'http://localhost:8080/api/products/images/one'}
   listType='picture-card'
   defaultFileList={fileList}
   multiple={true}
   onPreview={handlePreview}
   onChange={handleChange}
   onRemove={handleRemove}
   >
    {FileList.length>=8?null:uploadButton}
   </Upload>
   <Modal open={previewOpen}
    title={previewTitle}
    footer={null}
    onCancel={handleCancel}
   >
    <img src={previewImage} alt="review image" style={{ width:'100%'}}></img>
   </Modal>
   </>
  )
}

export default UploadImage
