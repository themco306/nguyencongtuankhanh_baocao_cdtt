package com.nguyencongtuankhanh.web_backend.domain;

import java.util.Objects;

import org.hibernate.Hibernate;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.Table;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
@Setter
@Getter
@AllArgsConstructor
@NoArgsConstructor
@Entity
@Table(name = "product_image")
public class ProductImage extends AbstractEntity {
    @Column(name = "name",nullable = false,length = 100)
    private String name;
    @Column(name = "file_name",nullable = false,length = 100)
    private String fileName;
    @Column(name = "url",nullable = false)
    private String url;

    @Override
    public boolean equals(Object o) {
        if (this == o)
            return true;
        if (o == null || Hibernate.getClass(this) != Hibernate.getClass(o))
            return false;
        ProductImage that = (ProductImage) o;
        return  Objects.equals(getId(), that.getId());
    }
    @Override
    public int hashCode(){
        return getClass().hashCode();
    }
}
