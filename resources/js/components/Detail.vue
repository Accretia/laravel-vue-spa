<template>
  <div class="container">
    <table class="table">
      <thead>
        <th>Type</th>
        <th>No of File</th>
        <th>Size</th>
      </thead>
      <tbody>
        <tr v-for="(input, index) in details" :key="index">
          <td>{{ index }}</td>
          <td>{{ input.no_of_file }}</td>
          <td>{{ ((input.size)/1000000).toFixed(2) }}MB ({{ (input.size) }}B)</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',
  data () {
    return {
      details: []
    }
  },

  created () {
    this.fetchData()
  },
  methods: {

    addRow () {
      this.inputs.push({
        string: ''

      })
    },
    fetchData () {
      axios.get('/api/file/detail')
        .then(response => {
          if (response.status === 200) {
            this.details = response.data
          }
        })
        .catch(function (error) {
          console.log(error)
        })
    }
  }
}
</script>
