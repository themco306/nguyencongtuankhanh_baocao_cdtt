package com.nguyencongtuankhanh.web_backend.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import com.nguyencongtuankhanh.web_backend.domain.ProductImage;

public interface ProductImageRepository extends JpaRepository<ProductImage, Integer> {
    // Các phương thức khác của repository
}
