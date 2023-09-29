package com.nguyencongtuankhanh.web_backend.domain;



import java.util.Date;
import java.util.LinkedHashSet;
import java.util.Set;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.JoinTable;
import jakarta.persistence.ManyToMany;
import jakarta.persistence.ManyToOne;
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
    @Column(name = "quantity",nullable = false)
    private Integer quantity;
    @Column(name = "price",nullable = false)
    private Double price;
    @Column(name = "discount",nullable = false)
    private Float discount;
     @Column(name = "view_count",nullable = false)
    private Long viewCount;
     @Column(name = "is_featured",nullable = false)
    private Boolean isFeatured;
    @Temporal(TemporalType.DATE)
    @Column(name = "created_at")
    private Date createdAt;
    @Temporal(TemporalType.DATE)
    @Column(name = "updated_at")
    private Date updatedAt;
    @Column(name = "detail",nullable = false,length = 2000)
    private String detail;
    @Column(name = "description",nullable = false,length = 200)
    private String description;
    @Temporal(TemporalType.DATE)
    @Column(name = "manufacture_date")
    private Date manufactureDate;

    @PrePersist
    public void prePersist(){
        createdAt=new Date();
        if(isFeatured==null){
            isFeatured=false;
        }
        viewCount=0L;
    }
    @PreUpdate
    public void preUpdate(){
        updatedAt= new Date();
    }
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
}
