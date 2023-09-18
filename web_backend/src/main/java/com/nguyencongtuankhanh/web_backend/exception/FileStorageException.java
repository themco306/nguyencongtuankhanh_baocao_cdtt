package com.nguyencongtuankhanh.web_backend.exception;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.ResponseStatus;

@ResponseStatus(HttpStatus.BAD_REQUEST)
public class FileStorageException extends RuntimeException{
    public FileStorageException(String mesage){
        super(mesage);
    }
    public FileStorageException(String mesage,Throwable cause){
        super(mesage,cause);
    }
}
