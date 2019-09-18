<template>
  <div class="container">
    <p>Total Size : {{((this.size)/1000000).toFixed(2)}}MB ({{(this.size)}}B)</p>
    <p>No. of File : {{this.numbersOfFile}}</p>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',
  data () {
    return {
      numbersOfFile: 0,
      size: 0
    }
  },

  created () {
    this.fetchData();
  },
  methods: {

    addRow () {
      this.inputs.push({
        string: ''

      })
    },
    fetchData (){
      axios.get('/api/file/overview')
        .then(response => {
          if (response.status === 200) {
            this.numbersOfFile = response.data.noOfFiles
            this.size = response.data.size
          }
        })
        .catch(function (error) {
          console.log(error)
        })
    }
  }
}
</script>
