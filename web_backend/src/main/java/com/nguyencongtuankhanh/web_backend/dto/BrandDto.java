package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;

import org.springframework.web.multipart.MultipartFile;

import com.fasterxml.jackson.annotation.JsonIgnore;

import jakarta.validation.constraints.NotEmpty;
import lombok.Data;

@Data
public class BrandDto implements Serializable {
    private  Integer id;
    
    @NotEmpty(message = "Tên danh mục không được để trống")
    private String name;
    
    private String logo;
    
    @JsonIgnore
    private MultipartFile logoFile;
    
    // Lombok will generate getters and setters
}