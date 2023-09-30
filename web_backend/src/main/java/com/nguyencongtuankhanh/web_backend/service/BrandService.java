package com.nguyencongtuankhanh.web_backend.service;

import java.io.IOException;
import java.nio.file.Files;
import java.time.LocalDateTime;
import java.util.Date;
import java.util.List;
import java.util.Optional;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.autoconfigure.data.web.SpringDataWebProperties.Pageable;
import org.springframework.data.domain.Page;
import org.springframework.data.jpa.domain.JpaSort.Path;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.dto.BrandDto;
import com.nguyencongtuankhanh.web_backend.exception.BrandException;
import com.nguyencongtuankhanh.web_backend.repository.BrandRepository;




@Service
public class BrandService {
    @Autowired
    private BrandRepository brandRepository;
    @Autowired
    private FileStorageService fileStorageService;

    private String createSlugFromName(String name) {
        String sanitized = name.trim().toLowerCase();
        String[] words = sanitized.split("\\s+");
        return String.join("-", words);
    }

    public Brand insertBrand(BrandDto dto) {
        List<Brand> existingBrands = brandRepository.findByNameContainsIgnoreCase(dto.getName());
        if (!existingBrands.isEmpty()) {
            throw new BrandException("Tên thương hiệu đã tồn tại!!");
        }
    
        Brand entity = new Brand();
        LocalDateTime date = LocalDateTime.now();
        dto.setCreated_at(date);
        dto.setCreated_by(1);
        BeanUtils.copyProperties(dto, entity);
        String slug = createSlugFromName(dto.getName());
        entity.setSlug(slug);
    
        if (dto.getLogoFile() != null) {
            String fileName = fileStorageService.storeLogoFile(dto.getLogoFile());
            entity.setLogo(fileName);
            dto.setLogoFile(null);
        }
    
        // Xử lý trường sortOrder
        if (dto.getSortOrder() != null&&dto.getSortOrder() !=0) {
            Optional<Brand> targetBrandOptional = brandRepository.findById(dto.getSortOrder());
            if (targetBrandOptional.isPresent()) {
                Brand targetBrand = targetBrandOptional.get();
                entity.setSortOrder(targetBrand.getSortOrder());
            } else {
                throw new BrandException("Thương hiệu mục tiêu không tồn tại!!");
            }
        }
    
        return brandRepository.save(entity);
    }
    public Brand updateBrand(int id, BrandDto dto) {
    
        Brand entity = findById(id);
        var date= LocalDateTime.now();
        dto.setUpdated_at(date);
        dto.setUpdated_by(1);
        String ignoreFields[] = new String[] {
            "created_at",
            "created_by",
            "logo"
          };
        BeanUtils.copyProperties(dto, entity,ignoreFields);
        String slug = createSlugFromName(dto.getName());
        entity.setSlug(slug);
        if (dto.getLogoFile() != null) {
            // Xóa tập tin logo cũ nếu tồn tại
            if (entity.getLogo() != null) {
                fileStorageService.deleteLogoFile(entity.getLogo());
            }
    
            // Lưu tập tin logo mới
            String fileName = fileStorageService.storeLogoFile(dto.getLogoFile());
            entity.setLogo(fileName);
        } else {
            entity.setLogo(entity.getLogo()); // Gán lại giá trị logo từ thực thể ban đầu
        }
    
        return brandRepository.save(entity);
    }



    public Brand updateBrandStatus(int id) {
        Brand brand = findById(id);
        int currentStatus = brand.getStatus();
        int newStatus = (currentStatus == 0) ? 1 : 0;
        brand.setStatus(newStatus);
        var date= LocalDateTime.now();
        brand.setUpdated_at(date);
        brand.setUpdated_by(1);
        
        return brandRepository.save(brand);
    }
    public List<?> findAll(){
        return brandRepository.findAll();
    }
    public Page<Brand> findAll(org.springframework.data.domain.Pageable pageable){
        return brandRepository.findAll(pageable);
    }
    public Page<Brand> findByName(String name,org.springframework.data.domain.Pageable pageable){
        return brandRepository.findByNameContainsIgnoreCase(pageable,name);
    }
    public Brand findById(int id){
        Optional<Brand> found=brandRepository.findById(id);
        if(found.isEmpty()){
            throw new BrandException("Thương hiệu có Id "+id+" không tồn tại");
        }
        return found.get();
    }
     @Transactional(rollbackFor = Exception.class)
    public Void deleteById(int id)
    {
        Brand existed=findById(id);
        if(existed.getLogo()!=null){
            fileStorageService.deleteLogoFile(existed.getLogo());
          }
        brandRepository.delete(existed);
        return null;
    }

    
}
