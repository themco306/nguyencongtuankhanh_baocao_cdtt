package com.nguyencongtuankhanh.web_backend.controller;

import java.util.Collection;
import java.util.stream.Collectors;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.web.PageableDefault;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PatchMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.dto.BrandDto;
import com.nguyencongtuankhanh.web_backend.exception.FileStorageException;
import com.nguyencongtuankhanh.web_backend.service.BrandService;
import com.nguyencongtuankhanh.web_backend.service.FileStorageService;
import com.nguyencongtuankhanh.web_backend.service.MapValidationErrorService;

import jakarta.servlet.http.HttpServletRequest;
import jakarta.validation.Valid;

@RestController
@RequestMapping("/api/v1/brand")
public class BrandController {
    @Autowired
    private BrandService brandService;
    @Autowired
    private FileStorageService fileStorageService;
    @Autowired
    MapValidationErrorService mapValidationErrorService;
    @PostMapping(consumes = {MediaType.APPLICATION_JSON_VALUE,MediaType.APPLICATION_FORM_URLENCODED_VALUE,MediaType.MULTIPART_FORM_DATA_VALUE},produces = MediaType.APPLICATION_JSON_VALUE)
    public ResponseEntity<?> createBrand(@Valid @ModelAttribute BrandDto dto, BindingResult result){
        ResponseEntity<?> responseEntity= mapValidationErrorService.mapValidationFields(result);
        if(responseEntity!=null){ 
            return responseEntity;
        }
        Brand entity=brandService.insertBrand(dto);
        dto.setId(entity.getId());
        dto.setLogo(entity.getLogo());

        return new ResponseEntity<>(dto, HttpStatus.CREATED);
    }
     @PatchMapping(value ="/{id}" ,consumes = {MediaType.APPLICATION_JSON_VALUE,MediaType.APPLICATION_FORM_URLENCODED_VALUE,MediaType.MULTIPART_FORM_DATA_VALUE},produces = MediaType.APPLICATION_JSON_VALUE)
    public ResponseEntity<?> updateBrand(@PathVariable("id") int id,@Valid @ModelAttribute BrandDto dto, BindingResult result){
        ResponseEntity<?> responseEntity= mapValidationErrorService.mapValidationFields(result);
        if(responseEntity!=null){ 
            return responseEntity;
        }
        Brand entity=brandService.updateBrand(id,dto);
        dto.setId(entity.getId());
        dto.setLogo(entity.getLogo());

        return new ResponseEntity<>(dto, HttpStatus.CREATED);
    }
    
    @GetMapping("/logo/{filename:.+}")
    public ResponseEntity<?> downloadFile(@PathVariable("filename") String fileName,HttpServletRequest request){
        Resource resource = fileStorageService.loadLogoFileAsResource(fileName);
        String contentType=null;
        try {
            contentType=request.getServletContext().getMimeType(resource.getFile().getAbsolutePath());

        } catch (Exception e) {
            throw new FileStorageException("Lấy file bị lỗi hoặc không tồn tại! Hãy thử lại");
        }
        if(contentType==null){
            contentType="application/octet-stream";
        }
        return ResponseEntity.ok()
                .contentType(MediaType.parseMediaType(contentType)).header(HttpHeaders.CONTENT_DISPOSITION,"attachment;filename=\""+ resource.getFilename()+"\"").body(resource);
    }
    @GetMapping
    public ResponseEntity<?> getBrand(){
        var list =brandService.findAll();
        var newList= list.stream().map(item->{
            BrandDto dto=new BrandDto();
            BeanUtils.copyProperties(item, dto);
            return dto;
       
        }).collect(Collectors.toList());
        return new ResponseEntity<>(newList,HttpStatus.OK);
    }

    @GetMapping("/find")
    public ResponseEntity<?> getBrand(@RequestParam("query") String query,@PageableDefault(size = 5,sort = "name",direction = Sort.Direction.ASC) Pageable pageable){
        var list =brandService.findByName(query,pageable);
        var newList= list.getContent().stream().map(item->{
            BrandDto dto=new BrandDto();
            BeanUtils.copyProperties(item, dto);
            return dto;
       
        }).collect(Collectors.toList());
        var newPage=new PageImpl<>(newList,list.getPageable(),list.getTotalPages());
        return new ResponseEntity<>(newPage,HttpStatus.OK);
    }

    @GetMapping("/page")
    public ResponseEntity<?> getBrand(@PageableDefault(size = 5,sort = "name",direction=Sort.Direction.ASC ) Pageable pageable ){
        var list =brandService.findAll(pageable);
        var newList = list.map(item -> {
            BrandDto dto = new BrandDto();
            BeanUtils.copyProperties(item, dto);
            return dto;
        }).getContent();
        return new ResponseEntity<>(newList,HttpStatus.OK);
    }

    @GetMapping("/{id}/get")
    public ResponseEntity<?> getBrand(@PathVariable("id") int id  ){
       var entity=brandService.findById(id);
       BrandDto dto = new BrandDto();
       BeanUtils.copyProperties(entity, dto);
        return new ResponseEntity<>(dto,HttpStatus.OK);
    }
    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteBrand(@PathVariable("id") int id){
        brandService.deleteById(id);
        return new ResponseEntity<>("Thương hiệu có Id "+id+" đã được xóa",HttpStatus.OK);
    }
}
