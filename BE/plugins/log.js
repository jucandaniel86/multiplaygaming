export default function ({ $axios, redirect }) {
  $axios.onError(message => {
    console.groupCollapsed('%c ERROR ', 'background: #FF0000; color: white; display: block;');
    console.log(message);
    console.groupEnd();
  });
  $axios.onRequest(message => {
    // console.log(message);
    let _message = typeof message.data !== "undefined" ? message.data : {};
    let _url = typeof message.url !== "undefined" ? message.url : "";
    let _params = typeof message.data !== "undefined" ? message.data : {};

    console.groupCollapsed('%c FRONTEND ', 'background: #C14803; color: white; display: block;');
    console.log({
      'URL': _url,
      'PARAMS': _params,
      'DATA': _message
    });
    console.groupEnd();
  });
  $axios.onResponse(message => {
    let _message, _url, _params;

    try {
      _message = typeof message.data !== "undefined" ? message.data : {};
      _url = typeof message.config.url !== "undefined" ? message.config.url : "";
      _params = typeof message.config.data !== "undefined" ? JSON.parse(message.config.data) : {};
    } catch(err) {}
 
    console.groupCollapsed('%c BACKEND ', 'background: #039005; color: white; display: block;');
    console.log({
      'URL': _url,
      'PARAMS': _params,
      'DATA': _message
    });
    console.groupEnd();
  }); 
}