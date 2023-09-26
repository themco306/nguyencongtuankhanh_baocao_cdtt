package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;
import java.time.LocalDateTime;

import jakarta.validation.constraints.NotEmpty;
import lombok.Data;

@Data
public class CategoryDto implements Serializable {
    private  int id;
    @NotEmpty(message = "Tên danh mục không được để trống")
    private String name;
    // private String slug;
    // private int parentId;
    // private int sortOrder;
    // private Integer level;
    // private String image;
    // private String metaKey;
    // private String metaDesc;
    // private LocalDateTime createdAt;
    // private int createdBy;
    // private LocalDateTime updatedAt;
    // private int updatedBy;
    private int status;

    // Lombok will generate getters and setters
}
