package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;
import java.time.LocalDateTime;
import java.util.Date;

import org.springframework.web.multipart.MultipartFile;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonIgnore;

import jakarta.validation.constraints.NotEmpty;
import lombok.Data;

@Data
public class BrandDto implements Serializable {
    private Integer id;

    @NotEmpty(message = "Tên danh mục không được để trống")
    private String name;

    private String logo;

    @NotEmpty(message = "Meta key không được để trống")
    private String metakey;

    @NotEmpty(message = "Meta description không được để trống")
    private String metadesc;

    private Integer sortOrder;

    private Integer updated_by;

    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime  updated_at;

    private Integer created_by;

    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime  created_at;

    private Integer status;

    @JsonIgnore
    private MultipartFile logoFile;
    
    // Lombok will generate getters and setters
}