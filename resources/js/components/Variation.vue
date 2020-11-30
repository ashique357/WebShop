<template>
<div class="card shadow mb-4">
      <div class="card-header py-3">
         <!-- <h6 class="m-0 font-weight-bold text-primary">Learner Application List</h6> -->
         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right" @click="openModal('#createModal')"><i class="fas fa-plus fa-sm text-white-50"></i> Add Variation</a>
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
                        <tr role="row" v-for="(variation , index) in paginatedData" :key="index">
                           <td v-text="index+1"></td>
                           <td v-text="variation.name"></td>
                            <td> 
                              <div class="form-group">
                                 <a class="btn btn-sm btn-primary" title="View" @click="showModal('#showModal',variation)"><i class="fas fa-eye"></i></a>
                                 <a class="btn btn-sm btn-secondary" title="Edit" @click="editModal('#editModal',variation)"><i class="fas fa-edit"></i></a>
                                 <a class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
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
      
      <!-- createModal -->
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Variation<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
            <form action="" method="Post" @submit.prevent="createVariation(store)">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Variation name:</b></label>
                        <input type="text" v-model="store.name" id="name1" class="form-control">
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
                  <h5 class="modal-title" id="exampleModalLabel">Variation Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Variation name:</b></label>
                        <p>{{show.name}}</p>   
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
                  <h5 class="modal-title" id="exampleModalLabel">Edit Variation Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
            <form action="" method="Post" @submit.prevent="updateVariation(show)">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Variation name:</b></label>
                        <input type="text" v-model="show.name" id="name" class="form-control">
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

const INDEX_URL="/api/admin/variation/index";
const STORE_URL="/api/admin/variation/store";
const UPDATE_URL="/api/admin/variation/update";
export default {
    mixins: [mixin],
   
    data(){
        return{
            columns:[
            {label: 'SL', name: '' },
            {label: 'Name', name: 'name' },
        ],
        show:[],
        store:{
           name:'',
        },

        accessControl:{
            edit:'',
            delete:'',
            create:''
    },
        }
    },
    methods: {
      getVariationData() {
        this.getData(INDEX_URL);
      },
      updateVariation(data) {
        this.updateData(UPDATE_URL,data);
      },

      createVariation(store) {
        this.store.name=store.name;
        this.$http.post(STORE_URL,this.store)
          .then(response=>{
                this.closeModal("#createModal");
                this.successSweetAlert();
                this.SuccessToaster();
                this.reload();
            })
            .catch(error=>{
                console.log(error.message);
                this.closeModal("#createModal");
                this.failedSweetAlert();
                this.FailedToaster();
                this.reload();
            })
      }
    },

    created(){
        this.getVariationData()
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
</style>
