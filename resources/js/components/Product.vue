<template>
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <!-- <h6 class="m-0 font-weight-bold text-primary">Learner Application List</h6> -->
         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right" @click="openModal('#createModal')"><i class="fas fa-plus fa-sm text-white-50"></i> Add Product</a>
      </div>
      <div class="card-body">
         <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
               <div class="col-sm-12 col-md-6">
                  <div class="dataTables_length" id="dataTable_length">
                     <label>
                        Show 
                        <select v-model="length" @change="resetPagination()" name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                           <option value="10">10</option>
                           <option value="20">20</option>
                           <option value="30">30</option>
                           <option value="100">100</option>
                        </select>
                        entries
                     </label>
                  </div>
               </div>
               <div class="col-sm-12 col-md-6">
                  <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable" v-model="search" @input="resetPagination()"></label></div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                     <thead>
                        <tr role="row">
                           <th v-for="column in $data.columns" :key="column.name" @click="sortBy(column.name)"
                              :class="$data.sortKey === column.name ? ($data.sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                              style="cursor:pointer;">
                              {{column.label}}
                           </th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th v-for="column in $data.columns" :key="column.name" @click="sortBy(column.name)"
                              :class="$data.sortKey === column.name ? ($data.sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                              style="cursor:pointer;">
                              {{column.label}}
                           </th>
                           <th>Actions</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <tr role="row" v-for="(product , index) in paginatedData" :key="index">
                           <td v-text="index+1"></td>
                           <td v-text="product.name"></td>
                           <td>{{product.slug}}</td>
                           <td>{{product.category_id}}</td>
                           <td><a class="image_class"><img :src="product.preview_image" alt="" /></a></td>
                           <td>
                              <div class="form-group">
                                 <a class="btn btn-sm btn-primary" title="View" @click="showModal('#showModal',product)"><i class="fas fa-eye"></i></a>
                                 <a class="btn btn-sm btn-secondary" title="Edit" @click="editModal('#editModal',product)"><i class="fas fa-edit"></i></a>
                                 <a class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                 <a class="dropdown">
                                 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="'dropdownMenu'+ index+1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Product Management
                                 </button>
                                 <a class="dropdown-menu" aria-labelledby="'dropdownMenu'+ index+1">
                                 <a class="dropdown-item btn btn-primary" :href="baseUrl+'admin/product/'+product.id">Product Management</a>
                                 </a>
                                 </a>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12 col-md-5">
                  <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite" v-if="!tableShow.showdata">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</div>
                  <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite" v-else>{{pagination.from}} - {{pagination.to}} of {{filteredData.length}}
                     <span v-if="filteredData.length < pagination.total"></span>
                  </div>
               </div>
               <div class="col-sm-12 col-md-12">
                  <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                     <ul class="pagination" v-if="!tableShow.showdata">
                        <li class="paginate_button page-item " v-if="pagination.prevPageUrl"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="--pagination.currentPage">Prev</a></li>
                        <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Prev</a></li>
                        <li class="paginate_button page-item " v-if="pagination.nextPageUrl"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="++pagination.currentPage">Next</a></li>
                        <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Next</a></li>
                     </ul>
                     <ul class="pagination" v-else>
                        <li class="paginate_button page-item " v-if="pagination.prevPage"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="--pagination.currentPage">Prev</a></li>
                        <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Prev</a></li>
                        <li class="paginate_button page-item " v-if="pagination.nextPage"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="++pagination.currentPage">Next</a></li>
                        <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Next</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- variation -->
      <div class="modal fade" id="variation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Variations<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form action="" method="Post" @submit.prevent="createVariation(varCreate)">
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-12">
                           <label for=""><b>Select Variation:</b></label>
                           <select name="" id="var_id" class="form-control" v-model="varCreate.var_id" @change="getVar">
                              <option disabled>Select Variation</option>
                              <option v-for="(va,index) in variations" :key="index" :value="index">{{va}}</option>
                           </select>
                        </div>
                        <div class="col-md-12">
                           <br>
                           <label for=""><b>Options:</b></label>
                           <div class="form-check form-check-inline" v-for="(value,index) in vars" :key="index+1">
                              <input class="form-check-input" type="checkbox" :id="'permission_'+ index" v-model="$data.value" :value="value.id">
                              <label :for="'permission' +index"><span class="badge badge-pill badge-primary">{{value.name}}</span></label>
                           </div>
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
      <!-- createModal -->
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Product<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form action="" method="Post" @submit.prevent="createProduct(store)">
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-12">
                           <label for=""><b>Product Name:</b></label>
                           <input type="text" v-model="store.name" id="name" class="form-control">
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Slug:</b></label>
                           <input type="text" v-model="store.slug" id="Slug" class="form-control">
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Select Category:</b></label>
                           <select name="" id="" class="form-control" v-model="store.category_id">
                              <option disabled>Select Category</option>
                              <option v-for="(ca,index) in categories" :key="index" :value="index">{{ca}}</option>
                           </select>
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Description:</b></label>
                           <textarea  class="form-control" id="desc" v-model="store.description" rows="15" cols="5"></textarea>
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
      <!-- showModal -->
      <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Product Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Product Name:</b></label>
                        <p>{{show.name}}</p>
                     </div>
                     <div class="col-md-12">
                        <label for=""><b>Slug:</b></label>
                        <p>{{show.slug}}</p>
                     </div>
                     <div class="col-md-12">
                        <label for=""><b>Category Name:</b></label>
                        <p>{{show.category_id}}</p>
                     </div>
                     <div class="col-md-12">
                        <label for=""><b>Preview Image:</b></label>
                        <p>{{show.previewImage}}</p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <div class="form-group">
                     <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- showModal -->
      <!-- editModal -->
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Product Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form action="" method="Post" @submit.prevent="updateProduct(show)">
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-12">
                           <label for=""><b>Product Name:</b></label>
                           <input type="text" v-model="show.name" id="name" class="form-control">
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Slug:</b></label>
                           <input type="text" v-model="show.slug" id="Slug" class="form-control">
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Select Category:</b></label>
                           <select name="" id="" class="form-control" v-model="show.category_id">
                              <option disabled>Select Category</option>
                              <option v-for="(ca,index) in categories" :key="index" :value="index">{{ca}}</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <div class="form-group">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                     </div>
                     <div class="form-group">
                        <button class="btn btn-primary">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- editModal -->
   </div>
</template>

<script>
import mixin from '../mixin'

const INDEX_URL="/api/admin/product/index";
const STORE_URL="/api/admin/product/store";
const UPDATE_URL="/api/admin/product/update";
export default {
    mixins: [mixin],
   
    data(){
        return{
         baseUrl:"http://127.0.0.1:8000/",
            columns:[
            {label: 'SL', name: '' },
            {label: 'Name', name: 'name' },
            {label: 'Slug', name: 'slug'},
            {label: 'Category Id', name: 'category_id'},
            {label: 'Preview Image', name: 'previewImage'},
        ],

        categories:[],
        show:[],
        store:{
           name:'',
           slug:'',
           category_id:'',
           description:'',
        },
        variationOptions:[],

        accessControl:{
            edit:'',
            delete:'',
            create:''
          },
          varCreate:{
             var_id:'',
             var_value:[]
          },
          vars:[],
        }
    },
    methods: {
      getProductData() {
        this.getData(INDEX_URL);
      },
      updateProduct(data) {
        this.updateData(UPDATE_URL,data);
      },

      createProduct(store) {
        this.store.name=store.name;
        this.store.slug=store.slug;
        this.store.category_id=store.category_id;
        this.store.description=store.description;
        console.log(store);
      //   this.$http.post(STORE_URL,this.store)
      //     .then(response=>{
      //           this.closeModal("#createModal");
      //           this.successSweetAlert();
      //           this.SuccessToaster();
      //          //  this.reload();
      //       })
      //       .catch(error=>{
      //           console.log(error.message);
      //           this.closeModal("#createModal");
      //           this.failedSweetAlert();
      //           this.FailedToaster();
      //          //  this.reload();
      //       })
      },

         getVar(){
            var val2=$("select[id='var_id']").children("option:selected").val();
            let URL="/api/admin/get-var?var_id="+val2;
            this.$http.get(URL)
            .then(resp=>{
                  this.vars=resp.data.variations;
                  console.log(resp.data.variations);
            })
            .catch(errors=>{
                  console.log(errors);
            })
        },
    },

    created(){
        this.getProductData();
    },
    computed:{
       
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
.image_class img{
   height:100px;
   width:100px;
}
</style>
