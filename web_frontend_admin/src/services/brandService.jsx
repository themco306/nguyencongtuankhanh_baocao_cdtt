import axios from "axios"
import { API_BRAND } from "./constant"

export default class BrandService{
    insertBrand = async(brand)=>{
        
        
        return await axios.post(API_BRAND,brand)
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
        return  await axios.patch(API_BRAND+"/"+id,brand)
    }
    updateBrandStatus=async(id)=>{
        return  await axios.patch(API_BRAND+"/"+id+"/status")
    }
    static getBrandLogoUrl=(filename)=>{
        return (API_BRAND+"/logo/"+filename)
    }
}