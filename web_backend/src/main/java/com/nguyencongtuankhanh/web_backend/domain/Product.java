package com.nguyencongtuankhanh.web_backend.domain;



import java.time.LocalDateTime;
import java.util.Date;
import java.util.LinkedHashSet;
import java.util.Set;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.JoinTable;
import jakarta.persistence.ManyToMany;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.OneToMany;
import jakarta.persistence.OneToOne;
import jakarta.persistence.PrePersist;
import jakarta.persistence.PreUpdate;
import jakarta.persistence.Table;
import jakarta.persistence.Temporal;
import jakarta.persistence.TemporalType;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@Entity
@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor
@Table(name = "product")
public class Product extends AbstractEntity{
    @Column(name = "name",nullable = false)
    private String name;
    @Column(name = "slug",nullable = false)
    private String slug;
    @Column(name = "metakey",nullable = false)
    private String metakey;
    @Column(name = "metadesc",nullable = false)
    private String metadesc;
    @Column(name = "quantity",nullable = false)
    private Integer quantity;
    @Column(name = "price",nullable = false)
    private Double price;
     @Column(name = "view_count",nullable = false)
    private Long view_count;
     @Column(name = "is_featured",nullable = false)
    private Boolean is_featured;
    @Column(name = "updated_by")
    private Integer updated_by;
    @Column(name = "created_by")
    private Integer created_by;
    @Column(name = "created_at")
    private LocalDateTime created_at;

    @Column(name = "updated_at")
    private LocalDateTime updated_at;
    @Column(name = "detail",nullable = false,length = 2000)
    private String detail;
    @Column(name = "description",nullable = false,length = 200)
    private String description;

    @Column(name = "manufacture_date")
    private LocalDateTime manufacture_date;

    @ManyToOne
    private Category category;
    @ManyToOne
    private Brand brand;
    @ManyToMany
    @JoinTable(name="product_product_images" ,joinColumns=@JoinColumn(name ="product_id"),inverseJoinColumns=@JoinColumn(name="prduct_images_id"))
    private Set<ProductImage> images=new LinkedHashSet<>();
    @OneToOne(orphanRemoval = true)
    @JoinColumn(name = "prduct_image_id")
    private ProductImage image;
    @Column(name = "status")
    private Integer status;

    @OneToMany(mappedBy = "product")
    private Set<ProductIncoming> product_incoming = new LinkedHashSet<>();
    @OneToMany(mappedBy = "product")
    private Set<ProductOutgoing> product_outgoing = new LinkedHashSet<>();
    @OneToOne(mappedBy = "product")
    private ProductSale product_sale;
}
