import axios from "axios"
import { API_BRAND } from "./constant"

export default class BrandService{
    insertBrand = async(brand)=>{
        let formData=new FormData();
        formData.append("name",brand.name)
        if(brand.logoFile[0].originFileObj){
            formData.append("logoFile",brand.logoFile[0].originFileObj)
        }
        return await axios.post(API_BRAND,formData)
    }
    getBrands=async()=>{
        return  await axios.get(API_BRAND)
    }
    getBrandsByName=async(params)=>{
        return  await axios.get(API_BRAND+'/find',{params})
    }
    deleteBrand=async(id)=>{
        return  await axios.delete(API_BRAND+"/"+id)
    }
    getBrand=async(id)=>{
        return  await axios.get(API_BRAND+"/"+id+"/get")
    }
    updateBrand=async(id,brand)=>{
        let formData=new FormData();
        formData.append("name",brand.name)
        if(brand.logoFile[0].originFileObj){
            formData.append("logoFile",brand.logoFile[0].originFileObj)
        }
        return  await axios.patch(API_BRAND+"/"+id,formData)
    }
    static getBrandLogoUrl=(filename)=>{
        return (API_BRAND+"/logo/"+filename)
    }
}