package com.nguyencongtuankhanh.web_backend.controller;

import com.nguyencongtuankhanh.web_backend.exception.FileStorageException;
import com.nguyencongtuankhanh.web_backend.service.FileStorageService;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

@RestController
@RequestMapping("/api/v1/products")
@CrossOrigin(origins = "http://localhost:3000")
public class ProductController {

  @Autowired
  private FileStorageService fileStorageService;
    
  @PostMapping(
    consumes = {
      MediaType.APPLICATION_JSON_VALUE,
      MediaType.APPLICATION_FORM_URLENCODED_VALUE,
      MediaType.MULTIPART_FORM_DATA_VALUE,
    },
    produces = MediaType.APPLICATION_JSON_VALUE
  )
  public ResponseEntity<?> uploadImage(
    @RequestParam("file") MultipartFile imageFile
  ) {}

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
}
