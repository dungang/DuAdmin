<template>
  <span>
    <img  :src="name" :style="{'border-radius':borderRadius+'rem','height':$attrs.height}"  />
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