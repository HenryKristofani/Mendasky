<template>
    <MainLogLayout>
      <div class="mt-10 mb-10">
        <Isiberita />
      </div>
    </MainLogLayout>
  </template>
  
  <script>
  import MainLogLayout from '../Layouts/MainLogLayout.vue';
  import Isiberita from './Berita/isiberita.vue';
  
  export default {
    components: {
        MainLogLayout,
        Isiberita
    }
  };
  </script>  