package com.nguyencongtuankhanh.web_backend.dto;



import lombok.Data;

@Data
public class UploadedFileInfo  {

    private String uid;//tương thích với upload của antd
    private String name;
    private String fileName;

}
