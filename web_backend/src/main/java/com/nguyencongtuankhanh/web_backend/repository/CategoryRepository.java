package com.nguyencongtuankhanh.web_backend.repository;

import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.domain.Category;



@Repository
public interface CategoryRepository extends JpaRepository<Category, Integer> {
      List<Category> findByNameContainsIgnoreCase(String name);
 Page<Category> findByNameContainsIgnoreCase(Pageable pageable,String name);
    List<Category> findByIdNotAndNameContainsIgnoreCase(int id,String name);
}
