<template>
  <span>
    <img v-bind="$attrs" :src="name" :style="{'border-radius':borderRadius+'px'}"  />
  </span>
</template>
<script>
export default {
  props: {
    name: String
  },
  computed: {
    borderRadius() {
      if (this.$attrs.borderRadius) {
        return this.$attrs.borderRadius;
      }
      return 0;
    }
  },
  inheritAttrs: false
};
</script>
<style scoped>
span {
  display: inline-flex;
  align-items: center;
}
span::before {
  content: "\200b";
}
</style>