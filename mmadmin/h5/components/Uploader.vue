<template>
  <van-uploader
    v-model="fileList"
    :after-read="afterRead"
    :max-count="maxCount"
    :deletable="deletable"
    @delete="onDelete"
  />
</template>
<script>
import Vue from "vue";
import { Uploader } from "vant";
import Moment from "moment";
import { compress } from "../lib/Utils";
Vue.use(Uploader);
export default {
  model: {
    prop: "ufiles",
    event: "change"
  },
  props: {
    deletable: {
      type: Boolean,
      default: true
    },
    ufiles: {
      type: Array,
      default: []
    },
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
    },
    maxHeight: {
      type: [Number, String],
      default: 160
    }
  },
  data() {
    return {
      fileList: []
    };
  },
  methods: {
    initFileList() {
      if (this.ufiles) {
        this.fileList = this.ufiles.map(url => {
          return { url: url };
        });
      }
    },
    afterRead(file) {
      if (MA && MA.uploader) {
        if (this.compress) {
          compress(file.content, this.maxHeight).then(data => {
            this.uploaderFile(file, data);
          });
        } else {
          this.uploaderFile(file, file.file);
        }
      }
    },
    uploaderFile(file, data) {
      this.$api.get("/site/upload-token", {}, res => {
        if (res.status == 200) {
          let token = res.data;
          let form = new FormData();
          let key = this.getObjKey(file.file.name);
          form.append(MA.uploader.keyName, key);
          form.append("file", data);
          form.append(MA.uploader.tokenName, token);
          file.status = "uploading";
          this.$api.upload(
            MA.uploader.uploadUrl,
            form,
            res => {
              file.url = MA.uploader.baseUrl + key;
              file.status = "done";
              this.emitChange();
            },
            error => {
              file.status = "failed";
            }
          );
        }
      });
    },
    getObjKey(fileName) {
      return (
        this.dir +
        "/" +
        Moment().format("L") +
        "/" +
        Moment().valueOf() +
        "." +
        this.getExtension(fileName)
      );
    },
    getExtension(fileName) {
      var index = fileName.lastIndexOf(".");
      return fileName.substr(index + 1);
    },
    onDelete(file) {
      this.$api.post("/site/upload-delete", { url: file.url }, res => {
        if (res.status == 200) {
          file.status = 'deleted';
          this.fileList = this.fileList.filter(file=>{
            return !file.status ;
          })
          this.emitChange();
        }
      });
    },
    emitChange() {
      this.$emit(
        "change",
        this.fileList.map(item => item.url)
      );
    }
  },
  watch: {
    ufiles(val) {
      this.initFileList();
    }
  },
  created() {
    this.initFileList();
  }
};
</script>