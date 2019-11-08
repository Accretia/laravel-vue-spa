<template>
  <card :title="$t('Gallery')">
    <div class="container">
      <!--SUCCESS-->
      <div v-if="isSuccess">
        <h2>Uploaded {{ uploadedFiles.length }} file(s) successfully.</h2>
        <p>
          <a href="javascript:void(0)" @click="reset()">Upload again</a>
        </p>
      </div>
      <!--FAILED-->
      <div v-if="isFailed">
        <h2>Uploaded failed.</h2>
        <p>
          <a href="javascript:void(0)" @click="reset()">Try again</a>
        </p>
        <pre>{{ uploadError }}</pre>
      </div>
      <!--UPLOAD-->
      <form v-if="isInitial || isSaving" enctype="multipart/form-data" novalidate>
        <h1>Upload images</h1>
        <div class="dropbox">
          <input type="file" multiple :name="uploadFieldName" :disabled="isSaving" accept="image/*"
                 class="input-file" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
          >
          <p v-if="isInitial">
            Drag your file(s) here to begin<br> or click to browse
          </p>
          <p v-if="isSaving">
            Uploading {{ fileCount }} files...
          </p>
        </div>
      </form>
      <div>
        <VueEasyLightbox
          :visible="visible"
          :imgs="imgs"
          :index="index"
          @hide="handleHide"
          @ok="handleHide"
        />
      </div>
      <div v-for="i in Math.ceil(files.length / 3)" class="row">
        <div v-for="item in files.slice((i - 1) * 3, i * 3)" class="col-md-4">
          <img :src="item.url" class="img-responsive img-thumbnail">
          <div>
            <button class="btn-view btn btn-primary" @click="showSingle(item.url)">
              View
            </button>
            <button class="btn-delete btn btn-danger" @click="actionDelete(item.url)">
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
import VueEasyLightbox from 'vue-easy-lightbox'
import axios from 'axios'
const STATUS_INITIAL = 0; const STATUS_SAVING = 1; const STATUS_SUCCESS = 2; const STATUS_FAILED = 3

export default {
  middleware: 'auth',
  components: {
    VueEasyLightbox
  },
  data () {
    return {

      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      uploadFieldName: 'photos[]',
      files: [],
      filename: '',
      imgs: '', // Img Url , string or Array
      visible: false,
      index: 0 // default
    }
  },

  computed: {
    isInitial () {
      return this.currentStatus === STATUS_INITIAL
    },
    isSaving () {
      return this.currentStatus === STATUS_SAVING
    },
    isSuccess () {
      return this.currentStatus === STATUS_SUCCESS
    },
    isFailed () {
      return this.currentStatus === STATUS_FAILED
    }
  },
  mounted () {
    this.reset()
  },

  created () {
    this.fetchData()
  },

  methods: {
    handleOk (bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault()
      // Trigger submit handler
      // this.handleSubmit()
    },
    actionDelete (url) {
      let fileArr = url.split('/')
      let fileNameX = fileArr.slice(-1).pop()
      let urlNew = 'api/file/delete/' + fileNameX
      axios.delete(urlNew)
        .then(response => {
          if (response.status === 200) {
            this.fetchData()
          } else {
            this.currentStatus = STATUS_FAILED
          }
        })
        .catch(function (error) {
          // console.log(error);
          this.uploadError = error.response
          this.currentStatus = STATUS_FAILED
        })
    },
    resetModal () {
      this.filename = ''
    },
    reset () {
      // reset form to initial state
      this.currentStatus = STATUS_INITIAL
      this.uploadedFiles = []
      this.uploadError = null
    },
    save (formData) {
      // upload data to the server
      this.currentStatus = STATUS_SAVING
      axios.post('/api/file/upload', formData)
        .then(response => {
          if (response.status === 200) {
            this.currentStatus = STATUS_SUCCESS
            this.fetchData()
          } else {
            this.currentStatus = STATUS_FAILED
          }
        })
        .catch(function (error) {
          // console.log(error);
          this.uploadError = error.response
          this.currentStatus = STATUS_FAILED
        })
    },

    filesChange (fieldName, fileList) {
      // handle file changes
      const formData = new FormData()

      if (!fileList.length) return

      // append the files to FormData
      Array
        .from(Array(fileList.length).keys())
        .map(x => {
          formData.append(fieldName, fileList[x], fileList[x].name)
        })

      // save it
      //console.log(formData)
      this.save(formData)
    },
    fetchData () {
      axios.get('/api/file/list')
        .then(response => {
          if (response.status === 200) {
            this.files = response.data
          }
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    showSingle (filePath) {
      this.imgs = filePath
      this.show()
    },
    show () {
      this.visible = true
    },
    handleHide () {
      this.visible = false
    }
  },

  metaInfo () {
    return { title: this.$t('Gallery') }
  }
}
</script>

<!-- SASS styling -->
<style lang="scss">
  .dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px; /* minimum height */
    position: relative;
    cursor: pointer;
  }

  .input-file {
    opacity: 0; /* invisible but it's there! */
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
  }

  .dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }

  .dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
  }
  .btn-delete{
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    opacity: 0.7;
  }
  .btn-view{
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    opacity: 0.7;
  }
</style>
