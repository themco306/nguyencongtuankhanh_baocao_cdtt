export default class ValidateRoot {
    static required = () => ({
      required: true,
      message: "Không được để trống",
    });
  
    static min = (length) => ({
      min: length,
      message: `Độ dài ngắn nhất là ${length} ký tự`,
    });
  
    static max = (length) => ({
      max: length,
      message: `Độ dài tối đa là ${length} ký tự`,
    });
  
    static noSpecialCharacters = () => ({
      pattern: /^[^\s!@#$%^&*()_+={}|[\]\\:';"<>?,./]+$/,
      message: 'Không chứa ký tự đặc biệt',
    });
  
    static noStartsWithNumber = () => ({
      pattern: /^(?![0-9])[a-zA-Z0-9_]/,
      message: 'Số không được đứng đầu',
    });
    static allowedImageFormats = (allowedFormats) => ({
      validator: (rule, value) => {
        if (!value || value.length === 0) {
          return Promise.resolve();
        }
        const fileFormat = value[0].uid.split('.').pop().toLowerCase();
        if (allowedFormats.includes(fileFormat)) {
          return Promise.resolve();
        } else {
          return Promise.reject(`Chỉ hỗ trợ ${allowedFormats.join(', ')}`);
        }
      },
    });
  }