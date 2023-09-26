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
public class ProductDto implements Serializable {
    private int id;
    @NotEmpty(message = "Tên không được để trống")
    private String name;
    @Min(value = 0)
    private Integer quantity;
    @Min(value = 0)
    private Double price;
    @Min(value = 0)
    @Min(value = 100)
    private Float discount;
    private Long viewCount;
    private Boolean isFeatured;
    private String detail;
    private String description;
    @JsonFormat(pattern = "yyyy-MM-dd")
    private Date manufactureDate;
    private ProductStatus status;

    private Integer categoryId;   
    private Integer brandId;

    private List<ProductImageDto> images;
    private ProductImageDto image;

    private CategoryDto category;
    private BrandDto brand;

}
