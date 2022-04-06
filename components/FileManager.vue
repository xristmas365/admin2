<template>
  <div class="my-4">
    <v-carousel v-if="slider">
      <v-carousel-item
        v-for="item in files"
        :key="item.id"
        :src="getSrc(item.url)"
        reverse-transition="fade-transition"
        transition="fade-transition"
        cycle
        hide-delimiter-background
      />
    </v-carousel>
    <div v-else>
      <v-alert
        v-model="alertError"
        border="left"
        dense
        type="error"
        dismissible
        transition="scale-transition"
      >
        {{ error }}
      </v-alert>
      <draggable v-model="files" tag="div" class="row my-0" :draggable="preview? '':'.uploaded-file'">
        <v-col
          v-for="file in files"
          :key="file.url"
          class="uploaded-file d-flex child-flex"
          :cols="cols"
        >
          <v-hover v-slot="{ hover }">
            <v-card :elevation="hover ? (elevation + 4) : elevation" @click="previewHandler(file)">
              <v-img
                class="white--text align-end"
                :src="getSrc(file.url)"
                :height="height"
              >
                <v-card-title v-if="hover && !preview" class="text-h6 white--text">
                  <v-btn color="error" small fab @click.stop="confirmDelete(file)">
                    <v-icon>
                      mdi-delete
                    </v-icon>
                  </v-btn>
                </v-card-title>
              </v-img>
            </v-card>
          </v-hover>
        </v-col>
        <v-col
          v-if="files.length < limit && !preview"
          class="d-flex child-flex"
          :cols="cols"
        >
          <v-skeleton-loader
            v-if="loading"
            class="mx-auto"
            max-width="300"
            type="card"
          />
          <v-hover v-else v-slot="{ hover }">
            <v-card
              class="d-flex justify-center align-center"
              :elevation="hover ? (elevation + 4) : elevation"
              :height="height"
            >
              <label class="profile-photo">
                <v-icon x-large>
                  {{ addIcon }}
                </v-icon>
                <input ref="fileupload" type="file" @change="addFile($event)">
              </label>
            </v-card>
          </v-hover>
        </v-col>
      </draggable>
      <v-dialog
        v-model="deleteDialog"
        width="500"
        persistent
        transition="scale-transition"
      >
        <v-card>
          <v-card-title class="deleteFile.url">
            Delete File?
          </v-card-title>
          <v-card-subtitle v-text="'Size: '+ getSize(deleteFile.size)" />
          <v-img
            :src="getSrc(deleteFile.url)"
            class="white--text align-end"
            height="400px"
          />
          <v-divider />
          <v-card-actions>
            <v-spacer />
            <v-btn
              color="error"
              @click="deleteHandler"
            >
              <v-icon>
                mdi-delete
              </v-icon>
              Delete
            </v-btn>
            <v-btn
              text
              @click="cancelConfirmDelete"
            >
              Cancel
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="previewDialog"
        transition="scale-transition"
        width="500"
        persistent
      >
        <v-card>
          <v-card-title>
            File Preview
            <v-spacer />
            <v-btn
              text
              @click="copyFileUrl(previewFile.url)"
            >
              <v-icon left>
                mdi-link
              </v-icon>
              Copy
            </v-btn>
            <v-btn
              text
              @click="cancelPreview"
            >
              close
            </v-btn>
          </v-card-title>
          <v-img
            :src="getSrc(previewFile.url)"
            contain
          />
        </v-card>
      </v-dialog>
    </div>
    <div v-if="label">
      {{ title }} <span class="error--text">{{ error && Array.isArray(error) ? error[0] : '' }}</span>
    </div>
  </div>
</template>
<script>
function formatBytes (bytes, decimals = 2) {
  if (bytes === 0) { return '0 Bytes' }

  const k = 1024
  const dm = decimals < 0 ? 0 : decimals
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

  const i = Math.floor(Math.log(bytes) / Math.log(k))

  return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
}

export default {
  name: 'FileManager',
  props: {
    value: {
      type: Array,
      default: () => ([]),
      required: true
    },
    limit: {
      type: Number,
      default: 5
    },
    label: {
      type: String,
      default: ''
    },
    error: {
      type: Array,
      default: () => ([])
    },
    cols: {
      type: String,
      default: '2'
    },
    height: {
      type: String,
      default: '200'
    },
    addIcon: {
      type: String,
      default: 'mdi-plus'
    },
    elevation: {
      type: Number,
      default: 5
    },
    preview: {
      type: Boolean,
      default: false
    },
    slider: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      loading: false,
      alertError: false,
      previewDialog: false,
      previewFile: {},
      deleteDialog: false,
      deleteFile: {}
    }
  },
  computed: {
    files: {
      get () {
        return this.value
      },
      set (v) {
        this.$emit('input', v)
      }
    },
    title: {
      get () {
        return this.label ? (this.label + ' (' + this.files.length + ((this.preview || this.slider) ? '' : ('/' + this.limit)) + ')') : ''
      }
    }
  },
  methods: {
    async addFile (e) {
      this.loading = true
      const image = e.target.files[0]
      const data = new FormData()
      data.append('images', image, image.name)

      try {
        const response = await this.$axios.$post('/api/file/upload', data)
        this.files.push(response.data)
        this.$emit('input', this.files)
        this.$refs.fileupload.value = null
      } catch (error) {
        // this.handleError('Uploading Error')
      }
      this.loading = false
    },
    confirmDelete (file) {
      this.deleteFile = file
      this.deleteDialog = true
    },
    cancelConfirmDelete () {
      this.deleteFile = {}
      this.deleteDialog = false
    },
    getSize (bytes) {
      return formatBytes(bytes)
    },
    getSrc (src) {
      return process.env.storageUrl + src
    },
    async deleteHandler () {
      const id = this.deleteFile.id
      try {
        await this.$axios.$delete(`api/file/delete/${id}`)
      } catch (error) {

      }
      const files = this.files.filter((x) => {
        return x.id !== id
      })
      this.$emit('input', files)
      this.deleteFile = {}
      this.deleteDialog = false
    },
    previewHandler (file) {
      this.previewFile = file
      this.previewDialog = true
    },
    cancelPreview () {
      this.previewFile = {}
      this.previewDialog = false
    },
    handleError (err = false) {
      this.alertError = err
    },
    copyFileUrl (file) {
      const link = this.getSrc(file)
      this.$copyText(link).then(function (e) {
        alert('Copied')
        console.log(e)
      }, function (e) {
        alert('Can not copy')
        console.log(e)
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.v-card {
  transition: opacity .4s ease-in-out;
}

.profile-photo {
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  margin: 0 auto;
  overflow: hidden;
  transition: all ease-in .2s;

  &.border {
    border: 2px solid #ffffff;
  }

  input[type="file"] {
    display: none;
  }

  img {
    width: 200px;
    height: auto;
  }

  &:hover {
    border-color: #4dbcd4;

    .profile-photo-caption {
      span {
        margin-top: 0;
        opacity: 1;
        visibility: visible;
      }
    }
  }

  &-caption {
    font-size: 20px;
    font-weight: bold;
    margin: 0;
    user-select: none;

    span {
      display: block;
      margin-top: -25px;
      font-size: 16px;
      color: #4dbcd4;
      text-align: center;
      opacity: 0;
      visibility: hidden;
      transition: all ease-in .2s;
    }
  }
}

.height-50 {
  min-height: 65vh;
}
</style>
