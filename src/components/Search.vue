<template>
  <div class="pwas-search-component">
      <div id="pwas-search-bar" class="horizontal layout center">
        <div id="pwas-close-button">
          <button class="pwas-back-button" aria-label="Close">
            <div class="pwas-back-svg">
              <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false">
                    <g>
                      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                    </g>
              </svg>
            </div>
          </button>
        </div>
        <div style="padding: 0 12px;" class="pwas-flex">
          <input id="paw-search-text" v-model="search" aria-label="Enter search text here and the search results will be automatically updated as you type" autocomplete="off" spellcheck="false" placeholder="search text">
        </div>
      </div>
      <div v-if="isSearching" class="horizontal layout center" style="padding: 0 64px 9px; margin-top: -12px;">
        <div class="flex horizontal layout center offlineLabel">
          <span>Searching...</span>
        </div>
      </div>
      <section class="pwas-result-section-wrapper">
        <label><!---->Top results<!----></label>
          <div class="horizontal layout wrap grid-container">
               <div class="pwas-result-item" v-for="item in results">
                  <div id="pwas-card" class="vertical layout  ">
                      <div id="pwas-image-container">
                        <a id="pwas-image-panel" :aria-label="item.title" :href="item.link" v-bind:style="styleObject(item.image)" >
                        </a>
                      </div>
                      <div style="position: relative;">
                        <a id="pwas-name" :href="item.link">
                          <span>{{item.title}}</span>
                        </a>
                      </div>
                    </div>
               </div>     
          </div>
      </section>
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
      url:'',
      search: '',
      results:[],
      isSearching: false
    }
  },
  created() {
      this.debounceSearch = _.debounce(this.triggerSearch, 500);
  },
  mounted(){
    let request = {
      action: 'search',
      aslp:"",
      asid:1,
      asl_get_as_array:1,
      options:"qtranslate_lang=0&set_intitle=None&set_incontent=None&set_inexcerpt=None&set_inposts=None"
    }
    this.post(request);
  },
  watch:{
    search:function( newvalue, oldValue ){
      this.debounceSearch();
    }
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
    styleObject(img){
      return {
        'background-image': "url('"+img+"')"
      }
    },
    triggerSearch(){
        let request = {
          action: 'search',
          aslp:this.search,
          asid:1,
          asl_get_as_array:1,
          options:"qtranslate_lang=0&set_intitle=None&set_incontent=None&set_inexcerpt=None&set_inposts=None"
        }
        this.post(request);
    }
  }
};
</script>

<style lang="scss">
  @import "../assets/scss/pwas.scss";
</style>