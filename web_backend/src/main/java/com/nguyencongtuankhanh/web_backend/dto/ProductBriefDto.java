package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;
import java.util.Date;
import java.util.List;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.nguyencongtuankhanh.web_backend.domain.ProductStatus;

import jakarta.validation.constraints.Min;
import jakarta.validation.constraints.NotEmpty;
import lombok.Data;
@Data
//tóm gọn của productDto
public class ProductBriefDto implements Serializable {
    private Integer id;
    private String name;
    private Integer quantity;
    private Double price;
    private Float discount;
    private Long viewCount;
    private Boolean isFeatured;
    private String detail;
    private String description;
    private Date manufactureDate;
    private Integer status;

    private String categoryName;   
    private String brandName;

    private String imageFileName;

}
