package com.nguyencongtuankhanh.web_backend.service;
import java.util.Optional;
import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.nguyencongtuankhanh.web_backend.domain.Category;
import com.nguyencongtuankhanh.web_backend.exception.CategoryException;
import com.nguyencongtuankhanh.web_backend.repository.CategoryRepository;

@Service
public class CategoryService {
    private final CategoryRepository categoryRepository;

    @Autowired
    public CategoryService(CategoryRepository categoryRepository) {
        this.categoryRepository = categoryRepository;
    }

    public Category save(Category entity) {
        return categoryRepository.save(entity);
    }
    public Category update(int id,Category entity){
        Optional<Category> existed =categoryRepository.findById(id);
        if(existed.isEmpty()){
            throw new CategoryException("Danh mục có Id là "+id+" không tồn tại.");
        }
        try {
            Category existedCategory = existed.get();
            
            // Update fields
            existedCategory.setName(entity.getName());
            // existedCategory.setSlug(entity.getSlug());
            // existedCategory.setParentId(entity.getParentId());
            // existedCategory.setSortOrder(entity.getSortOrder());
            // existedCategory.setLevel(entity.getLevel());
            // existedCategory.setImage(entity.getImage());
            // existedCategory.setMetaKey(entity.getMetaKey());
            // existedCategory.setMetaDesc(entity.getMetaDesc());
            // existedCategory.setCreatedAt(entity.getCreatedAt());
            // existedCategory.setCreatedBy(entity.getCreatedBy());
            // existedCategory.setUpdatedAt(entity.getUpdatedAt());
            // existedCategory.setUpdatedBy(entity.getUpdatedBy());
            existedCategory.setStatus(entity.getStatus());
        
            return categoryRepository.save(existedCategory);
        } catch (Exception e) {
            throw new CategoryException("Cập nhật danh mục thất bại.");
        }
        
       
    }
    public List<Category> findAll(){
        return categoryRepository.findAll();
    }
    public Page<Category> findAll(Pageable pageable){
        return categoryRepository.findAll(pageable);
    }
    public Category findById(int id){
        Optional<Category> found=categoryRepository.findById(id);
        if(found.isEmpty()){
            throw new CategoryException("Danh mục có Id là "+id+" không tồn tại." );
        }
        return found.get();
    }
    public void deleteById(int id){
        Category existed =findById(id);
        categoryRepository.delete(existed);
    }


}

