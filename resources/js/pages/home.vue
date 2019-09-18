<template>
  <card :title="$t('Overview')">
    <overview></overview>
    <detail></detail>
  </card>
</template>

<script>
import Overview from "../components/Overview";
import Detail from "../components/Detail";
export default {
  components: {Detail, Overview},
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
