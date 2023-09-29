package com.nguyencongtuankhanh.web_backend.service;

import com.nguyencongtuankhanh.web_backend.domain.Brand;
import com.nguyencongtuankhanh.web_backend.domain.Category;
import com.nguyencongtuankhanh.web_backend.domain.Product;
import com.nguyencongtuankhanh.web_backend.domain.ProductImage;
import com.nguyencongtuankhanh.web_backend.dto.ProductBriefDto;
import com.nguyencongtuankhanh.web_backend.dto.ProductDto;
import com.nguyencongtuankhanh.web_backend.dto.ProductImageDto;
import com.nguyencongtuankhanh.web_backend.exception.ProductException;
import com.nguyencongtuankhanh.web_backend.repository.ProductImageRepository;
import com.nguyencongtuankhanh.web_backend.repository.ProductRepository;

import lombok.var;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.stream.Collectors;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
public class ProductService {

  @Autowired
  private ProductRepository productRepository;

  @Autowired
  private ProductImageRepository productImageRepository;

  @Autowired
  private FileStorageService fileStorageService;

  @Transactional(rollbackFor = Exception.class)
  public ProductDto insertProduct(ProductDto dto) {
    Product entity = new Product();
    BeanUtils.copyProperties(dto, entity);
    var brand = new Brand();
    brand.setId(dto.getBrandId());
    entity.setBrand(brand);

    var category = new Category();
    category.setId(dto.getCategoryId());
    entity.setCategory(category);

    if (dto.getImage() != null) {
      var image = new ProductImage();
      BeanUtils.copyProperties(dto.getImage(), image);
      var savedImg = productImageRepository.save(image);
      entity.setImage(savedImg);
    }
    if (dto.getImages() != null && dto.getImages().size() > 0) {
      var entityList = saveProductImages(dto);
      entity.setImages(entityList);
    }
    var savedProduct = productRepository.save(entity);
    dto.setId(savedProduct.getId());
    return dto;
  }

  @Transactional(rollbackFor = Exception.class)
  public ProductDto updateProduct(int id, ProductDto dto) {
    var found = productRepository
      .findById(id)
      .orElseThrow(() -> new ProductException("Sản phẩm không tồn tại"));
    String ignoreFields[] = new String[] {
      "createdDate",
      "iamge",
      "images",
      "viewCount",
    };
    BeanUtils.copyProperties(dto, found, ignoreFields);
    if (dto.getImage().getId()!=null&&
      found.getImage().getId() != dto.getImage().getId()
    ) {
      fileStorageService.deleteProductImagesFile(
        found.getImage().getFileName()
      );

      ProductImage img = new ProductImage();
      BeanUtils.copyProperties(dto.getImage(), img);
      productImageRepository.save(img);
      found.setImage(img);
    }
    var brand = new Brand();
    brand.setId(dto.getBrandId());
    found.setBrand(brand);

    var category = new Category();
    category.setId(dto.getCategoryId());
    found.setCategory(category);

    if(dto.getImages().size()>0){
        var toDeleteFile=new ArrayList<ProductImage>();

        found.getImages().stream().forEach(item->{
            var existed=dto.getImages().stream().anyMatch(img->img.getId()==item.getId());
            if(!existed){
                toDeleteFile.add(item);
            }
        });
        if(toDeleteFile.size()>0){
            toDeleteFile.stream().forEach(item->{
                fileStorageService.deleteProductImagesFile(item.getFileName());
                productImageRepository.delete(item);
            });
        }
        var imgList=dto.getImages().stream().map(item->{
            ProductImage img = new ProductImage();
            BeanUtils.copyProperties(item,img);
            return img;
        }).collect(Collectors.toSet());
        found.setImages(imgList);

    }
    var savedEntity=productRepository.save(found);
    dto.setId(savedEntity.getId());
    return dto;
  }
  @Transactional(rollbackFor = Exception.class)
  public void deleteProductById(int id){
    var found=productRepository.findById(id).orElseThrow(()->new ProductException("Sản phẩm không tồ"));
    if(found.getImage()!=null){
      fileStorageService.deleteProductImagesFile(found.getImage().getFileName());
      productImageRepository.delete(found.getImage());
    }
    if(found.getImages().size()>0){
      found.getImages().stream().forEach(item->{
        fileStorageService.deleteProductImagesFile(item.getFileName());
        productImageRepository.delete(item);
      });
    }
    productRepository.delete(found);
  }
  public ProductDto getEditedProductById(int id) {
    var found = productRepository
      .findById(id)
      .orElseThrow(() -> new ProductException("Sản phẩm không tồn tại!"));
    ProductDto dto = new ProductDto();
    BeanUtils.copyProperties(found, dto);

    dto.setBrandId(found.getBrand().getId());
    dto.setCategoryId(found.getCategory().getId());

    var images = found
      .getImages()
      .stream()
      .map(item -> {
        ProductImageDto imgDto = new ProductImageDto();
        BeanUtils.copyProperties(item, imgDto);
        return imgDto;
      })
      .collect(Collectors.toList());
    dto.setImages(images);

    ProductImageDto imageDto = new ProductImageDto();
    BeanUtils.copyProperties(found.getImage(), imageDto);
    dto.setImage(imageDto);
    return dto;
  }

  public Page<ProductBriefDto> getProductBriefsByName(
    String name,
    Pageable pageable
  ) {
    var list = productRepository.findByNameContainsIgnoreCase(name, pageable);

    var newList = list
      .getContent()
      .stream()
      .map(item -> {
        ProductBriefDto dto = new ProductBriefDto();
        BeanUtils.copyProperties(item, dto);

        dto.setCategoryName(item.getCategory().getName());
        dto.setBrandName(item.getBrand().getName());
        dto.setImageFileName(item.getImage().getFileName());
        return dto;
      })
      .collect(Collectors.toList());

    var newPage = new PageImpl<>(
      newList,
      list.getPageable(),
      list.getTotalElements()
    );
    return newPage;
  }

  private Set<ProductImage> saveProductImages(ProductDto dto) {
    var entityList = new HashSet<ProductImage>();
    var newList = dto
      .getImages()
      .stream()
      .map(item -> {
        ProductImage image = new ProductImage();
        BeanUtils.copyProperties(item, image);
        var savedImage = productImageRepository.save(image);
        item.setId(savedImage.getId());

        entityList.add(savedImage);
        return item;
      })
      .collect(Collectors.toList());

    dto.setImages(newList);
    return entityList;
  }
}
