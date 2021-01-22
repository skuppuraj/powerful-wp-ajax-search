<template>
	<div class="pwas-carousel-component">
		
	</div>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';
import { Carousel, Slide } from 'vue-carousel';
import { serialize } from 'object-to-formdata';
export default {
name: 'Search',
data () {
  return {
    url:'',
    search: '',
    results:[],
    isSearching: false
  }
},
components: {
    Carousel
 },
 mounted(){
   let request = {
     action: 'carousel',
     aslp:"",
     asid:1,
     asl_get_as_array:1,
     options:"qtranslate_lang=0&set_intitle=None&set_incontent=None&set_inexcerpt=None&set_inposts=None"
   }
   this.post(request);
 },
 methods:{
   post(request) {
     let form_data = this.getFormData(request);
     this.isSearching = true;
     this.url = pwas_object.ajaxurl.toString().replace( '%%endpoint%%', request.action );
     let axiosConfig = {};
     if (process.env.NODE_ENV == 'development') {
       axiosConfig = {
         withCredentials: true,
         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
       };
     }else{
       axiosConfig = {
         withCredentials: true,
       };
     }
     return axios({
       method: 'post',
         url: `${this.url}`,
         data: form_data
       })
       .then(response => {
           this.results = response.data;
           this.isSearching = false;
       })
       .catch(error => console.log(error));
   },
   getFormData(object) {       
       return serialize(object);
   },
  }

};
</script>