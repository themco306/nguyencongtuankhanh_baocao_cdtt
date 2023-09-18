package com.nguyencongtuankhanh.web_backend.controller;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;

import org.springframework.data.web.PageableDefault;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PatchMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;

import org.springframework.web.bind.annotation.RestController;
import org.springframework.data.domain.Sort;

import com.nguyencongtuankhanh.web_backend.domain.Category;
import com.nguyencongtuankhanh.web_backend.dto.CategoryDto;
import com.nguyencongtuankhanh.web_backend.exception.CategoryException;
import com.nguyencongtuankhanh.web_backend.service.CategoryService;
import com.nguyencongtuankhanh.web_backend.service.MapValidationErrorService;

import jakarta.validation.Valid;

@RestController
@CrossOrigin(origins = "http://localhost:3000")
@RequestMapping("/api/v1/categories")
public class CategoryController {
    @Autowired
    CategoryService categoryService;

    @Autowired
    MapValidationErrorService mapValidationErrorService;

    @PostMapping
    public ResponseEntity<?>  createCategory (@Valid @RequestBody CategoryDto dto,BindingResult result){
        ResponseEntity<?> responseEntity=mapValidationErrorService.mapValidationFields(result);
        if (responseEntity!=null) return responseEntity;
        Category entity=new Category();
        BeanUtils.copyProperties(dto, entity);
        entity=categoryService.save(entity);
        dto.setId(entity.getId());
        return new ResponseEntity<>(dto, HttpStatus.CREATED);
    }
    @PatchMapping("/{id}")
    public ResponseEntity<?>  updateCategory (@PathVariable("id") int id, @RequestBody CategoryDto dto){
        Category entity=new Category();
        BeanUtils.copyProperties(dto, entity);
        entity=categoryService.update(id,entity);
        dto.setId(entity.getId());
        return new ResponseEntity<>(dto, HttpStatus.CREATED);
    }
    @GetMapping()
    public ResponseEntity<?> getCategories(){
        return new ResponseEntity<>(categoryService.findAll(),HttpStatus.OK);
    }
    @GetMapping("/page")
    public ResponseEntity<?> getCategories(@PageableDefault(size= 12,sort="name",direction=Sort.Direction.ASC) Pageable pageable){
        return new ResponseEntity<>(categoryService.findAll(pageable),HttpStatus.OK);
    }
    @GetMapping("/{id}/get")
    public ResponseEntity<?> getCategories(@PathVariable("id") int id){
        return new ResponseEntity<>(categoryService.findById(id),HttpStatus.OK);   
    }
    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteCategories(@PathVariable("id") int id){
        categoryService.deleteById(id);
        return new ResponseEntity<>("Danh mục có Id là "+id+" đã được xóa.",HttpStatus.OK);
    }
}

