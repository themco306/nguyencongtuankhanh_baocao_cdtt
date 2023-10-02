import ValidateRoot from "./valideRoot";

export default class ValidateBrand {
  static name = [
    ValidateRoot.required,
    ValidateRoot.min(3),
    ValidateRoot.max(40),
    ValidateRoot.noSpecialCharacters,
    ValidateRoot.noStartsWithNumber,
  ];
  static metakey = [
    ValidateRoot.required,
    ValidateRoot.min(3),
    ValidateRoot.max(60),
    ValidateRoot.noStartsWithNumber,
  ];
  static metadesc = [
    ValidateRoot.required,
    ValidateRoot.min(3),
    ValidateRoot.max(140),
    ValidateRoot.noStartsWithNumber,
  ];
  static logo = [
    ValidateRoot.required,
    ValidateRoot.allowedImageFormats(['jpg', 'jpeg', 'png', 'gif'])
  ];
}
