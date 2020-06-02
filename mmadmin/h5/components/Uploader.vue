<template>
  <van-uploader :after-read="afterRead" />
</template>
<script>
import Vue from "vue";
import { Uploader } from "vant";
Vue.use(Uploader);
export default {
  methods: {
    afterRead(file) {
      if (MA && MA.uploadeTokenResource) {
        this.$api.get("/site/token", {}, res => {
          if(res.status == 200) {
              let token = res.data;
          }
        });
      }
    }
  }
};
</script>