package com.nguyencongtuankhanh.web_backend.exception;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.ResponseStatus;

@ResponseStatus(HttpStatus.BAD_REQUEST)
public class FileNotFoundException extends RuntimeException{
    public FileNotFoundException(String mesage){
        super(mesage);
    }
    public FileNotFoundException(String mesage,Throwable cause){
        super(mesage,cause);
    }
}
