package com.nguyencongtuankhanh.web_backend.domain;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.PrePersist;
import jakarta.persistence.PreUpdate;
import jakarta.persistence.Table;
import jakarta.persistence.Temporal;
import jakarta.persistence.TemporalType;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.LocalDateTime;
import java.util.Date;

@AllArgsConstructor
@NoArgsConstructor
@Getter
@Setter
@Entity
@Table(name = "category")
public class Category extends AbstractEntity{

    @Column(name = "name", nullable = false)
    private String name;

    @Column(name = "slug", nullable = false)
    private String slug;

    @Column(name = "parent_id", columnDefinition = "int default 0")
    private Integer parent_id;

    @Column(name = "sort_order",  columnDefinition = "int default 0")
    private Integer sortOrder;


    @Column(name = "metakey", nullable = false)
    private String metakey;

    @Column(name = "metadesc", nullable = false)
    private String metadesc;

    @Column(name = "created_at")
    private LocalDateTime  created_at;

    @Column(name = "created_by")
    private Integer created_by;


    @Column(name = "updated_at")
    private LocalDateTime  updated_at;

    @Column(name = "updated_by")
    private Integer updated_by;

    @Column(name = "status", nullable = false, columnDefinition = "tinyint default 2")
    private Integer status;
}