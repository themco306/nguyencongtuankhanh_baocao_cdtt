package com.nguyencongtuankhanh.web_backend.service;

import com.nguyencongtuankhanh.web_backend.config.FileStorageProperties;
import com.nguyencongtuankhanh.web_backend.exception.FileNotFoundException;
import com.nguyencongtuankhanh.web_backend.exception.FileStorageException;
import java.io.File;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.UUID;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
import org.springframework.stereotype.Service;
import org.springframework.util.StringUtils;
import org.springframework.web.multipart.MultipartFile;

@Service
public class FileStorageService {

  private final Path fileLogoStorageLocation;

  public FileStorageService(FileStorageProperties fileStorageProperties) {
    this.fileLogoStorageLocation =
      Paths
        .get(fileStorageProperties.getUploadLogoDir())
        .toAbsolutePath()
        .normalize();
    try {
      Files.createDirectories(fileLogoStorageLocation);
    } catch (Exception e) {
      throw new FileStorageException("Không thể tìm thấy đường dẫn !!", e);
    }
  }


  
  public String storeLogoFile(MultipartFile file) {
    return storeFile(fileLogoStorageLocation, file);
  }

  private String storeFile(Path location, MultipartFile file) {
    UUID uuid = UUID.randomUUID();

    String ext = StringUtils.getFilenameExtension(file.getOriginalFilename());
    String fileName = uuid.toString() + "." + ext;
    try {
      if (fileName.contains("..")) {
        throw new FileStorageException(
          "Xin lỗi tên file có vấn đề " + fileName
        );
      }
      Path targetLocation = location.resolve(fileName);
      Files.copy(
        file.getInputStream(),
        targetLocation,
        StandardCopyOption.REPLACE_EXISTING
      );
      return fileName;
    } catch (Exception e) {
      throw new FileStorageException(
        "Không thể lưu file " + fileName + ". Hãy thử lại!! ",
        e
      );
    }
  }

  public Resource loadLogoFileAsResource(String fileName) {
    return loadFileAsResource(fileLogoStorageLocation, fileName);
  }

  private Resource loadFileAsResource(Path location, String fileName) {
    try {
      Path filePath = location.resolve(fileName).normalize();
      Resource resource = new UrlResource(filePath.toUri());
      if (resource.exists()) {
        return resource;
      } else {
        throw new FileNotFoundException("Không tìm thấy file " + fileName);
      }
    } catch (Exception e) {
      throw new FileNotFoundException("Không tìm thấy file " + fileName, e);
    }
  }

  public void deleteLogoFile(String fileName){
        deleteFile(fileLogoStorageLocation, fileName);
  }

  private void deleteFile(Path location, String fileName) {
    try {
      Path filePath = location.resolve(fileName).normalize();
      if(!Files.exists(filePath)){
        throw new FileNotFoundException("Không tìm thấy file "+fileName);
      }
      Files.delete(filePath);
    } catch (Exception e) {
        throw new FileNotFoundException("Không tìm thấy file "+fileName,e);
    }
  }
}
