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
          <input id="paw-search-text" aria-label="Enter search text here and the search results will be automatically updated as you type" autocomplete="off" spellcheck="false" placeholder="search text">
        </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'Search',
  data () {
    return {
      url:''
    }
  },
  mounted(){
    let request = {
      action: 'search',
      params:{
        action: 'search'
      }
    }
    this.post(request);
  },
  methods:{
    post(request) {
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
      return axios
        .post(`${this.url}`, request.params, axiosConfig)
        .then(response => {
          return console.log(response)
        })
        .catch(error => console.log(error));
    }
  }
};
</script>

<style lang="scss">
  @import "../assets/scss/pwas.scss";
</style>