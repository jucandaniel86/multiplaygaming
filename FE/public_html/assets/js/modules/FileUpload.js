export const __initFileUpload = () => {

  let filesWrapper = Array.from(document.querySelectorAll('.item_upload'));
  if (!filesWrapper.length) return false;

  filesWrapper.forEach(el => {
    let fileInput = el.querySelector('input[type=file]');
    //states
    let stateUploading = el.querySelector('.w-file-upload-uploading');
    let stateDefault = el.querySelector('.w-file-upload-default');
    let stateSuccess = el.querySelector('.w-file-upload-success');
    let wFilename = el.querySelector('.w-file-upload-file-name');
    let removeLink = el.querySelector('.w-file-remove-link');

    const removeLinkAction = () => {
      stateDefault.classList.remove('w-hidden');
      stateSuccess.classList.add('w-hidden');
      stateUploading.classList.add('w-hidden');
    }

    removeLink.addEventListener('click', removeLinkAction);

    fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        //loading start
        reader.onloadstart = () => {
          console.log('loading started')
        };
        //loading progress
        reader.onprogress = (event) => {
          stateDefault.classList.add('w-hidden');
          stateSuccess.classList.add('w-hidden');
          stateUploading.classList.remove('w-hidden');
        };
        //loading success
        reader.onload = () => {
          stateDefault.classList.add('w-hidden');
          stateUploading.classList.add('w-hidden');
          stateSuccess.classList.remove('w-hidden');

          wFilename.innerHTML = file.name;
        };
        reader.readAsDataURL(file);
      } else {
        //to do display message
        fileInput.value = '';
      }
    })
  });


}
