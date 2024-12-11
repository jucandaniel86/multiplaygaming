export default function useHelper() {

  const validObjectProp = (obj, propertyPath) => {
    if (!propertyPath)
      return false;

    var properties = propertyPath.split('.');

    for (var i = 0; i < properties.length; i++) {
      var prop = properties[i];

      if (!obj || !obj.hasOwnProperty(prop)) {
        return false;
      } else {
        obj = obj[prop];
      }
    }

    return true;
  }

  const extractArrayJSON = (props) => {
    let data = [];
    try {
      data = JSON.parse(props);
    } catch (err) {
    }

    return data;
  }

  return {
    validObjectProp,
    extractArrayJSON
  }
}
