<template>
  <van-uploader v-model="fileList" :after-read="afterRead" />
</template>
<script>
import Vue from "vue";
import { Uploader } from "vant";
import Moment from "moment";
import { compress } from "../lib/Utils";
Vue.use(Uploader);
export default {
  props: {
    dir: {
      type: String,
      default: "image"
    },
    compress: {
      type: Boolean,
      default: false
    },
    maxCount: {
      type: [Number, String],
      default: 1
    },
    maxSize: {
      type: [Number, String],
      default: 1 * 1024 * 1024
    }
  },
  data() {
    return {
      fileList: []
    };
  },
  methods: {
    afterRead(file) {
      if (MA && MA.uploader) {
        compress(file.content).then(data => {
          this.uploaderFile(file,data);
        });
      }
    },
    uploaderFile(file,data) {
      this.$api.get("/site/token", {}, res => {
        if (res.status == 200) {
          let token = res.data;
          let form = new FormData();
          let key = this.getObjKey(file.file);
          form.append(MA.uploader.keyName, key);
          form.append("file", data);
          form.append(MA.uploader.tokenName, token);
          file.status = "uploading";
          this.$api.upload(
            MA.uploader.resource,
            form,
            res => {
              file.url = MA.uploader.baseUrl + key;
              file.status = "done";
            },
            error => {
              file.statue = "failed";
            }
          );
        }
      });
    },
    getObjKey(file) {
      return (
        this.dir +
        "/" +
        Moment().format("L") +
        "/" +
        Moment().valueOf() +
        "." +
        this.getExtension(file.name)
      );
    },
    getExtension(fileName) {
      var index = fileName.lastIndexOf(".");
      return fileName.substr(index + 1);
    }
  }
};
</script>