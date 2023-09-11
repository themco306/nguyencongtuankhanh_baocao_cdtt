package com.nguyencongtuankhanh.web_backend.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.nguyencongtuankhanh.web_backend.domain.Category;



@Repository
public interface CategoryRepository extends JpaRepository<Category, Integer> {
  
}
