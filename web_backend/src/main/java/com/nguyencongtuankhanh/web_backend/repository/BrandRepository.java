package com.nguyencongtuankhanh.web_backend.repository;

import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;

import com.nguyencongtuankhanh.web_backend.domain.Brand;

public interface BrandRepository extends JpaRepository<Brand,Integer> {
    List<Brand> findByNameContainsIgnoreCase(String name);
     Page<Brand> findByNameContainsIgnoreCase(String name,Pageable pageable);
    List<Brand> findByIdNotAndNameContainsIgnoreCase(int id,String name);

}
