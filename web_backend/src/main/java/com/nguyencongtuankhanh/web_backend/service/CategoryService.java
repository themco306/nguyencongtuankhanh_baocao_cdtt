package com.nguyencongtuankhanh.web_backend.service;
import java.util.Optional;
import java.time.LocalDateTime;
import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.domain.Category;
import com.nguyencongtuankhanh.web_backend.dto.CategoryDto;
import com.nguyencongtuankhanh.web_backend.exception.BrandException;
import com.nguyencongtuankhanh.web_backend.exception.CategoryException;
import com.nguyencongtuankhanh.web_backend.repository.CategoryRepository;

@Service
public class CategoryService {
    private final CategoryRepository categoryRepository;

    @Autowired
    public CategoryService(CategoryRepository categoryRepository) {
        this.categoryRepository = categoryRepository;
    }
    private String createSlugFromName(String name) {
        String sanitized = name.trim().toLowerCase();
        String[] words = sanitized.split("\\s+");
        return String.join("-", words);
    }
    public Category insertCategory(CategoryDto dto) {
        List<?> foundedList = categoryRepository.findByNameContainsIgnoreCase(dto.getName());
        if (foundedList.size() > 0) {
            throw new CategoryException("Tên thương hiệu đã tồn tại!!");
        }
        Category entity = new Category();
        var date= LocalDateTime.now();
        dto.setCreated_at(date);
        dto.setCreated_by(1);
        BeanUtils.copyProperties(dto, entity);
        String slug = createSlugFromName(dto.getName());
        entity.setSlug(slug);
        if (dto.getSortOrder() != null&&dto.getSortOrder() !=0) {
            Optional<Category> targetBrandOptional = categoryRepository.findById(dto.getSortOrder());
            if (targetBrandOptional.isPresent()) {
                Category targetBrand = targetBrandOptional.get();
                entity.setSortOrder(targetBrand.getId());
            } else {
                throw new CategoryException("Danh mục mục tiêu không tồn tại!!");
            }
        }
        if (dto.getParent_id() != null&&dto.getParent_id() !=0) {
            Optional<Category> targetBrandOptional = categoryRepository.findById(dto.getParent_id());
            if (targetBrandOptional.isPresent()) {
                Category targetBrand = targetBrandOptional.get();
                entity.setParent_id(targetBrand.getId());
            } else {
                throw new CategoryException("Danh mục cha không tồn tại!!");
            }
        }
        return categoryRepository.save(entity);
    }
    public Category updateCategory(int id,CategoryDto dto){

        try {
           Category entity = findById(id);
            var date= LocalDateTime.now();
            dto.setUpdated_at(date);
            dto.setUpdated_by(1);
            String ignoreFields[] = new String[] {
                "created_at",
                "created_by",
            };
            BeanUtils.copyProperties(dto, entity,ignoreFields);
            String slug = createSlugFromName(dto.getName());
            entity.setSlug(slug);
            if (dto.getSortOrder() != null&&dto.getSortOrder() !=0) {
            Optional<Category> targetBrandOptional = categoryRepository.findById(dto.getSortOrder());
            if (targetBrandOptional.isPresent()) {
                Category targetBrand = targetBrandOptional.get();
                entity.setSortOrder(targetBrand.getId());
            } else {
                throw new CategoryException("Danh mục mục tiêu không tồn tại!!");
            }
        }
        if (dto.getParent_id() != null&&dto.getParent_id() !=0) {
            Optional<Category> targetBrandOptional = categoryRepository.findById(dto.getParent_id());
            if (targetBrandOptional.isPresent()) {
                Category targetBrand = targetBrandOptional.get();
                entity.setParent_id(targetBrand.getId());
            } else {
                throw new CategoryException("Danh mục cha không tồn tại!!");
            }
        }
            return categoryRepository.save(entity);
        } catch (Exception e) {
            throw new CategoryException("Cập nhật danh mục thất bại.");
        }
        
       
    }
    public Category updateCategoryStatus(int id) {
        Category category = findById(id);
        int currentStatus = category.getStatus();
        int newStatus = (currentStatus == 0) ? 1 : 0;
        category.setStatus(newStatus);
        var date= LocalDateTime.now();
        category.setUpdated_at(date);
        category.setUpdated_by(1);
        
        return categoryRepository.save(category);
    }
    public List<Category> findAll(){
        return categoryRepository.findAll();
    }
    public Page<Category> findAll(Pageable pageable){
        return categoryRepository.findAll(pageable);
    }
    public Page<Category> findByName(String name,org.springframework.data.domain.Pageable pageable){
        return categoryRepository.findByNameContainsIgnoreCase(pageable,name);
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

