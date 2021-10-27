<template>
  <van-nav-bar
    :title="title"
    :left-text="leftText"
    :right-text="rightText"
    left-arrow
    :fixed="fixed"
    @click-left="onClickLeft"
    @click-right="onClickRight"
  />
</template>
<script>
import Vue from "vue";
import { NavBar } from "vant";
Vue.use(NavBar);
export default {
  props: {
    home: {
      type: String,
      default: "home",
    },
    title: {
      type: String,
      default: "",
    },
    leftText: {
      type: String,
      default: "返回",
    },
    rightText: {
      type: String,
      default: "",
    },
    fixed: {
      type: Boolean,
      default: false,
    },
    onClickRight: {
      type: Function,
      default() {},
    },
  },
  methods: {
    onClickLeft() {
      if (window.history.length === 0) {
        this.$router.push(this.home);
      } else {
        this.$router.go(-1);
      }
    },
  },
};
</script>