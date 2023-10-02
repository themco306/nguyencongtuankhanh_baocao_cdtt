package com.nguyencongtuankhanh.web_backend.repository;

import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.domain.Category;
import com.nguyencongtuankhanh.web_backend.domain.Product;

public interface ProductRepository extends JpaRepository<Product,Integer> {
    Page<Product> findByNameContainsIgnoreCase(String name,Pageable pageable);
  List<Product> findByNameContainsIgnoreCase(String name);

    List<Product> findByIdNotAndNameContainsIgnoreCase(int id,String name);
}
