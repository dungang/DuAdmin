<template>
  <span>
    <img v-if="$attrs.src" :src="$attrs.src" :style="{'border-radius':borderRadius+'rem', height:$attrs.height}" />
  </span>
</template>
<script>
export default {
  computed: {
    borderRadius() {
      if(this.$attrs.radius) {
        return this.$attrs.radius;
      }
      if (this.$attrs.height) {
        return parseFloat(this.$attrs.height) / 2;
      }
      return parseFloat(this.$attrs.width) / 2;
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