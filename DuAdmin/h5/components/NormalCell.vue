<template>
  <div class="normal-cell">
    <div class="cell">
      <label class="label" :style="{width:labelWidth}">{{title}}</label>
      <div class="content">
          <slot>{{content}}</slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      default: ""
    },
    content: {
      type: String,
      default: ""
    },
    labelWidth: {
      type: String,
      default: "2rem"
    }
  }
};
</script>
<style lang="less" scoped>
.normal-cell {
    padding: 0.2rem 0.4rem ;
  .cell {
    display: flex;
    .lable {
        color: #666;
    }
    .content {
      flex: 1;
      color: #999;
    }
  }
}
</style>