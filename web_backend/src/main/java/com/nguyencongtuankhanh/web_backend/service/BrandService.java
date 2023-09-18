package com.nguyencongtuankhanh.web_backend.service;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.autoconfigure.data.web.SpringDataWebProperties.Pageable;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Service;

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

    public Brand insertBrand(BrandDto dto) {
        List<?> foundedList = brandRepository.findByNameContainsIgnoreCase(dto.getName());
        if (foundedList.size() > 0) {
            throw new BrandException("Tên thương hiệu đã tồn tại!!");
        }
    
        Brand entity = new Brand();
        BeanUtils.copyProperties(dto, entity);
    
        if (dto.getLogoFile() != null) {
            String fileName = fileStorageService.storeLogoFile(dto.getLogoFile());
            entity.setLogo(fileName);
            dto.setLogoFile(null);
        }
    
        return brandRepository.save(entity);
    }

     public Brand updateBrand(int id,BrandDto dto) {
        var  found= brandRepository.findById(id);
        if (found.isEmpty()) {
            throw new BrandException("Thương hiệu không tồn tại!!");
        }
    
        Brand entity = new Brand();
        BeanUtils.copyProperties(dto, entity);
    
        if (dto.getLogoFile() != null) {
            String fileName = fileStorageService.storeLogoFile(dto.getLogoFile());
            entity.setLogo(fileName);
            dto.setLogoFile(null);
        }
    
        return brandRepository.save(entity);
    }

    public List<?> findAll(){
        return brandRepository.findAll();
    }
    public Page<Brand> findAll(org.springframework.data.domain.Pageable pageable){
        return brandRepository.findAll(pageable);
    }
    public Page<Brand> findByName(String name,org.springframework.data.domain.Pageable pageable){
        return brandRepository.findByNameContainsIgnoreCase(name,pageable);
    }
    public Brand findById(int id){
        Optional<Brand> found=brandRepository.findById(id);
        if(found.isEmpty()){
            throw new BrandException("Thương hiệu có Id "+id+" không tồn tại");
        }
        return found.get();
    }

    public Void deleteById(int id)
    {
        Brand existed=findById(id);
        brandRepository.delete(existed);
        return null;
    }

    
}
