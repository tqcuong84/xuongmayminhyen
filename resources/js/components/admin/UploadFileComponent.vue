<template>
  <div :id="wrapper_id">
    <div v-if="photo_uploaded != '' && multiple != 'true'" class="photo-view-container">
      <img :src="photo_uploaded" />
      <button type="button" class="btn btn-sm photo-view-container__remove" @click="removeFileUploaded"><i class="fa fa-times"></i></button>
    </div>
    <input
        class="fileupload"
        type="file"
        name="file"
        :data-url="getUploadUrl"
        :accept="file_type"
        multiple
        v-if="multiple == 'true'"
        />
    <input
        class="fileupload"
        type="file"
        name="file"
        :data-url="getUploadUrl"
        :accept="file_type"
        v-else
        />
    <div class="file-upload-progress-container" :style="{'display': 'none'}">
        <div class="file-upload-progress">
            <div
                class="file-upload-progress__progress-bar"
                role="progressbar"
                aria-valuemin="0"
                aria-valuemax="100"
                style="width: 1%"
            >
                1%
            </div>   
        </div>
        <button type="button" class="btn btn-link btn-sm file-upload-progress__cancel-upload" ><i class="fa fa-times"></i></button> 
    </div>
    <draggable v-model="photos" class="photos-container" v-if="multiple == 'true'">
      <div v-for="(photo, photo_index) in photos" class="photo-view-item draggable-cursor" :key="'photo-' + photo_index">
        <img :src="photo.url" />
        <button type="button" class="btn btn-sm photo-view-item__remove" @click="removeFileMultiUploaded(photo_index)"><i class="fa fa-times"></i></button>
        <input type="hidden" class="file-upload__input-file-name" name="multi_file_name[]" :value="photo.name" />
      </div>
    </draggable>
    <input type="hidden" class="file-upload__input-file-name" :name="input_file_name" value="" />
    <input type="hidden" class="file-upload__input-folder-name" :name="input_folder_name" value="" />
  </div>
</template>

<script>
import draggable from 'vuedraggable';
export default {
  data() {
    return {
      photo_uploaded: (this.file_uploaded !== undefined)?this.file_uploaded:'',
      photos: [],
    };
  },
  props: ["file_type", "file_uploaded", "input_file_name", "input_file_name_value", "input_folder_name", "input_folder_name_value", "wrapper_id", "upload_url", "allow_resolution","multiple","multi_file_name_uploaded"],

  computed: {
    getUploadUrl: function() {
      return this.upload_url;
    },
  },

  methods: {
    init() {
      var $ = window.$; // use the global jQuery instance

      var self = this;
      $("#" + self.wrapper_id + " .file-upload__input-file-name").val(self.input_file_name_value);
      $("#" + self.wrapper_id + " .file-upload__input-folder-name").val(self.input_folder_name_value);
      //self.photo_uploaded = self.file_uploaded;
      var $fileUpload = $("#" + this.wrapper_id + " .fileupload");
      if ($fileUpload.length > 0) {
        // A quick way setup - url is taken from the html tag
        $fileUpload.fileupload({
          maxChunkSize: parseInt(window.upload_max_chunk_size),
          method: "POST",
          // Not supported
          sequentialUploads: false,
          formData: function(form) {
            // Append token to the request - required for web routes
            return [
              {
                name: "_token",
                value: $("input[name=_token]").val(),
              },
            ];
          },
          progress: function(e, data) {
            $("#" + self.wrapper_id + " .file-upload-progress__progress-bar").show();
            self.$emit("fileUploading", data.result);
            var progress = parseInt((data.loaded / data.total) * 100, 10);
            if (progress < 1) progress = 1;
            $("#" + self.wrapper_id + " .file-upload-progress__progress-bar")
              .css("width", progress + "%")
              .html(progress + "%");
            if (progress == 100) {
              $("#" + self.wrapper_id + " .file-upload-progress").slideUp();
            }
          },
          add: async function(e, data) {
            if(self.allow_resolution !== undefined && self.allow_resolution !== null && self.allow_resolution !== ""){
              let original_file = data.originalFiles[0]; 
              let original_resolution = await self.getResolutionImageFileUpload(original_file);
              if(original_resolution != self.allow_resolution){
                  self.$emit("wrongResolution", {
                    original_resolution,
                    allow_resolution: self.allow_resolution
                  });
                  return;
              }
            }
            $("#" + self.wrapper_id + " .file-upload-progress-container").show();
            $("#" + self.wrapper_id + " .file-upload-progress__progress-bar")
              .css("width", 1 + "%")
              .html(1 + "%");
            // data.submit();
            var jqXHR = data.submit();

            // abort upload
            $("#" + self.wrapper_id + " .file-upload-progress__cancel-upload").bind("click", function(e) {
              e.preventDefault();
              jqXHR.abort();
              $("#" + self.wrapper_id + " .file-upload-progress-container").hide();
            });

            $("#" + self.wrapper_id + " .file-upload-progress").slideDown();
          },

          success: function(e, data) {},
          done: function(e, data) {
            if (data.result.code == 1) {
              $("#" + self.wrapper_id + " .file-upload__input-folder-name").val(data.result.path);
              if(self.multiple == 'true'){
                let photos = self.photos;
                photos.push({
                  name: data.result.name,
                  url: '/storage/' + data.result.path + data.result.name
                });
              } else{
                self.photo_uploaded = '/storage/' + data.result.path + data.result.name;
                $("#" + self.wrapper_id + " .file-upload__input-file-name").val(data.result.name);
              }
            }
            $("#" + self.wrapper_id + " .file-upload-progress-container").hide();
          },
          beforeSend: function(xhr) {
          },
        });
      }
    },

    removeFileUploaded(){
        this.photo_uploaded = '';
        $("#" + this.wrapper_id + " .file-upload__input-file-name").val('');
        $("#" + this.wrapper_id + " .file-upload__input-folder-name").val('');
    },

    removeFileMultiUploaded(photo_index){
       let photos = this.photos.filter((item, index) => index != photo_index);
       this.photos = [...photos];
    },


    async getResolutionImageFileUpload(file) {
        return new Promise((resolve, reject) => {
            let ext = file.name.split('.').pop();
            let image_ext = ["jpg","jpeg","png","gif"]
            if(image_ext.includes(ext) === true){
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function (e) {
                  var img = new Image();
                  img.onload = function() {
                    resolve(this.width + 'x' + this.height);
                  }
                  img.src = reader.result;
                }
                reader.onerror = reject;
            } else{
                resolve("");
            }
        });
    },
  },

  components: { draggable },
  mounted() {
    this.init();
    let photos = [];
    if(this.multi_file_name_uploaded !== undefined && this.multi_file_name_uploaded !== null && this.multi_file_name_uploaded != ''){
      photos = JSON.parse(this.multi_file_name_uploaded);
      this.photos = [...photos];
    }
  },
};
</script>
<style lang="scss"></style>
