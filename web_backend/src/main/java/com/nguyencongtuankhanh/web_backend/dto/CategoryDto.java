package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;
import java.time.LocalDateTime;

import com.fasterxml.jackson.annotation.JsonFormat;

import jakarta.validation.constraints.NotEmpty;
import lombok.Data;

@Data
public class CategoryDto implements Serializable {
    private  Integer id;
    @NotEmpty(message = "Tên danh mục không được để trống")
    private String name;
    private Integer parent_id;
    private Integer sortOrder;
    private String metakey;
    private String metadesc;
    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime created_at;
    private Integer created_by;
    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime updated_at;
    private Integer updated_by;
    private Integer status;

    // Lombok will generate getters and setters
}
