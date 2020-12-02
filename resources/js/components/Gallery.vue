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
                     <li class="image_class" v-for="(image,index) in galleries" :key="index">
                        <input type="checkbox" id="'myCheckbox_0'+index"/>
                        <label for="'myCheckbox'+ index"><img :src="image.medium" alt="" />
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
        galleries:[],
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

    }

};
</script>


<style scoped>

ul {
  list-style-type: none;
}

.image_class{
  display: inline-block;
}

input[type="checkbox"][id^="myCheckbox"] {
  display: none;
}

label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked + label img {
  transform: scale(0.9);
  /* box-shadow: 0 0 5px #333; */
  z-index: -1;
}
</style>