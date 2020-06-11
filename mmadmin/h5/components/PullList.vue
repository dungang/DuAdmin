<template>
  <van-pull-refresh v-model="refreshing" @refresh="onRefresh">
    <van-list v-model="loading" :finished="finished" finished-text="没有更多了" @load="onLoad">
      <slot v-for="item in list" :item="item"></slot>
    </van-list>
  </van-pull-refresh>
</template>
<script>
import Vue from "vue";
import { List, PullRefresh } from "vant";
Vue.use(List).use(PullRefresh);
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
      refreshing: false,
      query: this.params,
      page: 1
    };
  },
  methods: {
    onLoad() {
      this.query.page = this.page;
      this.$api.get(this.resource, this.query, res => {
        if (this.refreshing) {
          this.list = [];
          this.refreshing = false;
        }
        let items = res.data.list;
        if (items && items.length > 0) {
          for (let i = 0; i < items.length; i++) {
            this.list.push(items[i]);
          }
          this.$emit('change',res.data);
          this.page += 1;
        } else {
          this.finished = true;
        }
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
    },
  },
  mounted(){
    this.$on('refresh',this.onRefresh);
  }
};
</script>