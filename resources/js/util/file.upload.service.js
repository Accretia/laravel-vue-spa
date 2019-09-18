import * as axios from 'axios'

const BASE_URL = 'http://localhost:8089'

function upload (formData) {
  const url = `${BASE_URL}/api/file/upload`
  return axios.post(url, formData)
    // get data
    .then(x => x.data)
  // add url field
    .then(x => x.map(img => Object.assign({},
      img, { url: 'http://localhost:8089' })))
}

export { upload }
