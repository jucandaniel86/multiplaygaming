import Vue from 'vue';
// import CKEditor from '@ckeditor/ckeditor5-vue2'; 
 

import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {
	image: {
		uploadURL: "http://api-affiliates.parfum.casa/api/images/upload",
		dropzoneOptions: {}
	},
}); 

// Vue.use( CKEditor );