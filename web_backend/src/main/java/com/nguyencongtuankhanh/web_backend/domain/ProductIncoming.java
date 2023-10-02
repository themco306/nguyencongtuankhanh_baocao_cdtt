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

@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor
@Entity
@Table(name = "product_incoming")
public class ProductIncoming extends AbstractEntity {
    @ManyToOne
    private Product product;
    @Column(name = "quantity", nullable = false)
    private Integer quantity;
    @Column(name = "incoming_price", nullable = false)
    private Double incoming_price;
    @Column(name = "received_at")
    private LocalDateTime received_at;

}
