<template>
  <div>
    <Search></Search>
    <Carousel></Carousel>
  </div>
</template>

<script>
import Search from './components/Search.vue'
import Carousel from './components/Carousel.vue'

export default {
  name: 'App',
  components: {
    Search,
    Carousel

  }
}
</script>
