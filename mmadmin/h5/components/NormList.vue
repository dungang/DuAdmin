<template>
  <van-list v-model="loading" :finished="finished" finished-text="没有更多了">
    <slot v-for="item in list" :item="item"></slot>
  </van-list>
</template>
<script>
import Vue from "vue";
import { List } from "vant";
Vue.use(List);
export default {
  props: {
    resource: {
      type: String,
      default: null
    },
    params: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      list: [],
      loading: false,
      finished: false,
      query: this.params
    };
  },
  methods: {
    onLoad() {
      this.$api.get(this.resource, this.query, res => {
        this.list = res.data.list;
        this.$emit("change", res.data);
        this.finished = true;
        this.loading = false;
      });
    },
    onRefresh() {
      // 清空列表数据
      this.finished = false;

      // 重新加载数据
      // 将 loading 设置为 true，表示处于加载状态
      this.loading = true;
      this.page = 1;
      this.list = [];
      this.onLoad();
    }
  },
  mounted() {
    this.$on("refresh", this.onRefresh);
    this.onLoad();
  }
};
</script>