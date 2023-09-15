const validateCategoryName=[
    {
        required:true,
        message:"Vui lòng nhập tên danh mục!",
    },
    {
        min:3,
        message:"Tên ít nhất 3 ký tự!",
    }
];
export {validateCategoryName}