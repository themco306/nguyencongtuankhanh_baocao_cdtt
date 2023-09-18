package com.nguyencongtuankhanh.web_backend.exception;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.ResponseStatus;

@ResponseStatus(HttpStatus.BAD_REQUEST)
public class BrandException extends RuntimeException{
    public BrandException(String mesage){
        super(mesage);
    }
}
