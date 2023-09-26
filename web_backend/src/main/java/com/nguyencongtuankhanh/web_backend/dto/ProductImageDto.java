package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;

import lombok.Data;

@Data
public class ProductImageDto  implements Serializable{
    private int id;
    private String uid;//tương thích với upload của antd
    private String name;
    private String fileName;
    private String url;//tương thích với upload của antd
    private String status;
    private String response="{\"status\":\"success\"}";
}
