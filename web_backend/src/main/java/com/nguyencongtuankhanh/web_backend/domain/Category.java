package com.nguyencongtuankhanh.web_backend.domain;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.LocalDateTime;

@AllArgsConstructor
@NoArgsConstructor
@Getter
@Setter
@Entity
@Table(name = "nctk_category")
public class Category extends AbstractEntity{

    @Column(name = "name", nullable = false)
    private String name;

    // @Column(name = "slug", nullable = false)
    // private String slug;

    // @Column(name = "parent_id", nullable = false, columnDefinition = "int default 0")
    // private int parentId;

    // @Column(name = "sort_order", nullable = false)
    // private int sortOrder;

    // @Column(name = "level")
    // private Integer level;

    // @Column(name = "image")
    // private String image;

    // @Column(name = "metakey", nullable = false)
    // private String metaKey;

    // @Column(name = "metadesc", nullable = false)
    // private String metaDesc;

    // @Column(name = "created_at", nullable = false)
    // private LocalDateTime createdAt;

    // @Column(name = "created_by", nullable = false, columnDefinition = "tinyint default 0")
    // private int createdBy;

    // @Column(name = "updated_at")
    // private LocalDateTime updatedAt;

    // @Column(name = "updated_by", columnDefinition = "tinyint default 0")
    // private int updatedBy;

    @Column(name = "status", nullable = false, columnDefinition = "tinyint default 2")
    private int status;
}