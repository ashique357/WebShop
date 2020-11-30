<template>
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <!-- <h6 class="m-0 font-weight-bold text-primary">Learner Application List</h6> -->
         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right" @click="openModal('#createModal')"><i class="fas fa-plus fa-sm text-white-50"></i> Add Gallery Images</a>
      </div>
      <div class="card-body">
         <form action="" method="POST">
            <div class="row">
               <div class="col-md-12">
                  <ul>
                     <br>
                     <label for=""><b>Small</b></label>
                     <li class="image_class" v-for="(image,index) in galleries" :key="index">
                        <input type="checkbox" id="'myCheckbox_0'+index" v-model="imageData.images" :value="image.id"/>
                        <label for="'myCheckbox'+ index"><img :src="image.small" alt="" />
                        </label>
                     </li>
                  </ul>
               </div>
            </div>
         </form>
      </div>
      <!-- createModal -->
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Gallery <strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form action="" method="Post" @submit.prevent="submitFiles">
                  <div class="modal-body">
                     <div class="row">
                        <div class="large-12 medium-12 small-12 cell">
                           <label>Upload Images
                           <input type="file" id="files" ref="files" multiple v-on:change="handleFilesUploads()"/>
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <div class="form-group">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                     </div>
                     <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- createModal -->
   </div>
</template>
<script>
import mixin from '../mixin'

const INDEX_URL="/api/admin/gallery/index";
const STORE_URL="/api/admin/gallery/store";

export default {
    mixins: [mixin],
    data(){
        return{
            columns:[
            {label: 'SL', name: '' },
            {label: 'Small', name: 'small' },
            {label: 'Medium', name: 'medium'},
            {label: 'Large', name: 'large'},
        ],
        show:[],
        store:{
            files:[],
        },
          accessControl:{
            edit:'',
            delete:'',
            create:''
    },
        }
    },

    methods: {
      getGalleryData() {
        this.getData(INDEX_URL);
      },

        handleFilesUploads(){
            this.files = this.$refs.files.files;
        },

        submitFiles(){
            let formData = new FormData();
            for( var i = 0; i < this.files.length; i++ ){
            let file = this.files[i];
            formData.append('files[' + i + ']', file);
            } 

            axios.post( STORE_URL,formData,{headers: {'Content-Type': 'multipart/form-data'}}
            ).then(function(resp){
            console.log(resp);
            })
            .catch(function(){
            console.log('FAILURE!!');
            });
        },

        getImage : function(path){
            return publicUrl+'/public'+path;
        },
    },

    created(){
        this.getGalleryData();
    }

};
</script>


<style scoped>
td li{
   list-style :none;
}

li{
   list-style: none;
}

.list_image{
    width:30px;
    height: 30px;
}
</style>
