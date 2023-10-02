package com.nguyencongtuankhanh.web_backend.controller;

import com.nguyencongtuankhanh.web_backend.dto.BrandDto;
import com.nguyencongtuankhanh.web_backend.dto.ProductDto;
import com.nguyencongtuankhanh.web_backend.dto.ProductImageDto;
import com.nguyencongtuankhanh.web_backend.exception.FileStorageException;
import com.nguyencongtuankhanh.web_backend.service.FileStorageService;
import com.nguyencongtuankhanh.web_backend.service.MapValidationErrorService;
import com.nguyencongtuankhanh.web_backend.service.ProductService;

import jakarta.servlet.http.HttpServletRequest;
import jakarta.validation.Valid;

import java.util.List;
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
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PatchMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

@RestController
@RequestMapping("/api/products")
@CrossOrigin(origins = "http://localhost:3000")
public class ProductController {

  @Autowired
  private FileStorageService fileStorageService;
  
  @Autowired
  MapValidationErrorService mapValidationErrorService;

  @Autowired
  private ProductService productService;
  @PostMapping
  public ResponseEntity<?> createProduct(@Valid @RequestBody ProductDto dto,BindingResult result){
    ResponseEntity<?> responseEntity=mapValidationErrorService.mapValidationFields(result);

    if(responseEntity!=null){
      return responseEntity;
    }
    var savedDto=productService.insertProduct(dto);
    return new ResponseEntity<>(savedDto,HttpStatus.CREATED);
  }
  @GetMapping("{id}/getedit")
  public ResponseEntity<Object> getEditProductById(@PathVariable int id){
    return new ResponseEntity<>(productService.getEditedProductById(id),HttpStatus.OK);
  }  
  @PostMapping(value = "/images/one",
    consumes = {
      MediaType.APPLICATION_JSON_VALUE,
      MediaType.APPLICATION_FORM_URLENCODED_VALUE,
      MediaType.MULTIPART_FORM_DATA_VALUE,
    },
    produces = MediaType.APPLICATION_JSON_VALUE
  )
  public ResponseEntity<?> uploadImage(
    @RequestParam("file") MultipartFile imageFile
  ) {
    var fileInfo = fileStorageService.storeUploadedProductImagesFile(imageFile);
    ProductImageDto dto = new ProductImageDto();
    BeanUtils.copyProperties(fileInfo, dto);
    dto.setStatus("done");
    dto.setUrl("http://localhost:8080/api/v1/products/images/"+fileInfo.getFileName());
    return new ResponseEntity<>(dto,HttpStatus.CREATED);
  }
  @DeleteMapping("/images/{fileName:.+}")
  public ResponseEntity<?> deleteImage(@PathVariable String fileName){
    fileStorageService.deleteProductImagesFile(fileName);
    return new ResponseEntity<>(HttpStatus.OK);
  }
  @GetMapping("/images/{filename:.+}")
  public ResponseEntity<?> downloadFile(
    @PathVariable("filename") String fileName,
    HttpServletRequest request
  ) {
    Resource resource = fileStorageService.loadProductImagesFileAsResource(
      fileName
    );
    String contentType = null;
    try {
      contentType =
        request
          .getServletContext()
          .getMimeType(resource.getFile().getAbsolutePath());
    } catch (Exception e) {
      throw new FileStorageException(
        "Lấy file bị lỗi hoặc không tồn tại! Hãy thử lại"
      );
    }
    if (contentType == null) {
      contentType = "application/octet-stream";
    }
    return ResponseEntity
      .ok()
      .contentType(MediaType.parseMediaType(contentType))
      .header(
        HttpHeaders.CONTENT_DISPOSITION,
        "attachment;filename=\"" + resource.getFilename() + "\""
      )
      .body(resource);
  }
  @PatchMapping(value = "/{id}/all")
  public ResponseEntity<?> updateProduct(@PathVariable("id") int id,@Valid @RequestBody ProductDto dto,BindingResult result){
    ResponseEntity<?> responseEntity=mapValidationErrorService.mapValidationFields(result);

    if(responseEntity!=null){
      return responseEntity;
    }
    var updatedDto=productService.updateProduct(id, dto);
    return new ResponseEntity<>(updatedDto,HttpStatus.CREATED);
  }
  @DeleteMapping("/{id}")
  public ResponseEntity<?> deleteProduct(@PathVariable int id){
    productService.deleteProductById(id);
    return new ResponseEntity<>("Sản phẩm có Id: "+id+" đã được xóa!!",HttpStatus.OK);
  }
     @GetMapping("/find")
    public ResponseEntity<?> getProductBriefByName(@RequestParam("query") String query,@PageableDefault(size = 5,sort = "name",direction = Sort.Direction.ASC) Pageable pageable){
        
        return new ResponseEntity<>(productService.getProductBriefsByName(query, pageable),HttpStatus.OK);
    }

    @GetMapping
    public ResponseEntity<?> getBrand(){
        var list = productService.findAll();
        var newList= list.stream().map(item -> {
            ProductDto dto = new ProductDto();
            BeanUtils.copyProperties(item, dto);
          
            // Copy image information
            if (item.getImage() != null) {
                ProductImageDto imageDto = new ProductImageDto();
                BeanUtils.copyProperties(item.getImage(), imageDto);
                dto.setImage(imageDto);
            }
    
            // Copy images information
            if (item.getImages() != null) {
                List<ProductImageDto> imagesDto = item.getImages().stream().map(image -> {
                    ProductImageDto imageDto = new ProductImageDto();
                    BeanUtils.copyProperties(image, imageDto);
                    return imageDto;
                }).collect(Collectors.toList());
                dto.setImages(imagesDto);
            }
    
            return dto;
        }).collect(Collectors.toList());
        return new ResponseEntity<>(newList, HttpStatus.OK);
    }
    
}
