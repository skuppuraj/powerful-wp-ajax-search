<template>
	<div class="pwas-carousel-component">
      <div class="pwas-carousel-wrapper">
        <div v-for="item in results" class="film-strip-item">
          <a :href="item.url">
            <div class="card-wrapper" v-html="item.html">
             
            </div>
          </a>
        </div>
      </div>
      <div id="overlay" class="horizontal layout center">
        <div class="soso-icon-button">
          <button aria-label="Scroll left" class="soso-button">
            <div class="soso-icon">
              <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false">
                <g>
                  <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
                </g>
              </svg>
            </div>
          </button>
        </div>
        <span class="flex"></span>
        <div class="soso-icon-button">
          <button aria-label="Scroll right" class="soso-button">
            <div class="soso-icon">
              <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false">
                <g>
                  <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                </g>
              </svg>
            </div>
          </button>
        </div>        
      </div>
	</div>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';
import { serialize } from 'object-to-formdata';
export default {
name: 'Search',
data () {
  return {
    results:[],
    isLoading: false
  }
},
 mounted(){
   let request = {
     action: 'carousel'
   }
   this.post(request);
 },
 methods:{
   post(request) {
     let form_data = this.getFormData(request);
     this.isLoading = true;
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
           this.isLoading = false;
       })
       .catch(error => console.log(error));
   },
   getFormData(object) {       
       return serialize(object);
   },
   styleObject(img){
     return {
       'background-image': "url('"+img+"')"
     }
   },
  }

};
</script>

<style lang="scss">
  @import "../assets/scss/pwas-carousel.scss";
</style>