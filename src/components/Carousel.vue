<template>
	<div class="pwas-carousel-component">
		  <!-- <div id="bar">
          <div id="container">
            <div id="hs" class="virtual-list">
              <div style="margin-left: 5px; width: 155px; height: 60px; position: absolute; transform: translate(0px, 0px);">
                <div v-for="item in results" class="film-strip-item">
                  <a :href="item.url">
                    <div id="pwa-img-card" class="horizontal layout center ">
                      <div id="imageCell" v-bind:style="styleObject(item.img)"></div>
                      <div>{{item.post_title}}</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
      </div> -->
      <div class="pwas-carousel-wrapper">
        <div v-for="item in results" class="film-strip-item">
          <a :href="item.url">
            <div class="card-wrapper" v-html="item.html">
             
            </div>
          </a>
        </div>
      </div>
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
    results:[],
    isLoading: false
  }
},
components: {
    Carousel,
    Slide
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