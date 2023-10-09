package com.nguyencongtuankhanh.web_backend.dto;

import java.io.Serializable;
import java.time.LocalDateTime;
import java.util.Date;
import java.util.List;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.nguyencongtuankhanh.web_backend.domain.ProductStatus;

import jakarta.validation.constraints.Max;
import jakarta.validation.constraints.Min;
import jakarta.validation.constraints.NotEmpty;
import lombok.Data;

@Data
public class ProductDto implements Serializable {
    private Integer  id;
    @NotEmpty(message = "Tên không được để trống")
    private String name;
    @Min(value = 0)
    private Integer quantity;
    @NotEmpty(message = "Meta key không được để trống")
    private String metakey;

    @NotEmpty(message = "Meta description không được để trống")
    private String metadesc;
    @Min(value = 0)
    private Double price;
    private Long view_count;
    private Boolean is_featured;
    private String detail;
    private String description;
    @JsonFormat(pattern = "yyyy-MM-dd")
    private LocalDateTime manufacture_date;
    private Integer status;

    private Integer category_id;   
    private Integer brand_id;
     private Integer updated_by;

    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime  updated_at;

    private Integer created_by;

    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private LocalDateTime  created_at;
    private List<ProductImageDto> images;
    private ProductImageDto image;

    private CategoryDto category;
    private BrandDto brand;

    // // New fields
    // private List<ProductIncomingDto> product_incoming;
    // private List<ProductOutgoingDto> product_outgoing;
    // private ProductSaleDto product_sale;
}
