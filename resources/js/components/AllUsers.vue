<template>
<div class="card shadow mb-4">
      <div class="card-header py-3">
         <!-- <h6 class="m-0 font-weight-bold text-primary">Learner Application List</h6> -->
         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right" @click="openModal('#createModal')" v-can="accessControl.create"><i class="fas fa-plus fa-sm text-white-50"></i> Add User</a>
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
                        <tr role="row" v-for="(user , index) in paginatedData" :key="index">
                           <td v-text="index+1"></td>
                           <td v-text="user.name"></td>
                           <td>{{user.email}}</td>
                           <td>{{user.phone}}</td>
                           <td>{{getStatus(user.status)}}</td>
                           <td><li v-for="(role,index_1) in user.roles" :key="index_1">
                                 {{role.name}}
                              </li></td>
                           <td>
                              <div class="form-group">
                                 <a class="btn btn-sm btn-primary" title="View" @click="showModal('#showModal',user)"><i class="fas fa-eye"></i></a>
                                 <a class="btn btn-sm btn-secondary" title="Edit" @click="editModal('#editModal',user)" v-can="accessControl.edit"><i class="fas fa-edit"></i></a>
                                 <a class="btn btn-sm btn-danger" title="Delete" v-can="accessControl.delete"><i class="fas fa-trash"></i></a>
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
                  <h5 class="modal-title" id="exampleModalLabel">Add User<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
            <form action="" method="Post" @submit.prevent="createUser(store)">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Username:</b></label>
                        <input type="text" v-model="store.name" id="name1" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Email:</b></label>
                        <input type="email" v-model="store.email" id="email1" class="form-control">
                     </div>
                     <div class="col-md-12">
                        <label for=""><b>Password:</b></label>
                        <input type="password" v-model="store.password" id="pass1" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Phone:</b></label>
                        <input type="text" v-model="store.phone" id="phone1" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Status:</b></label>
                        <select name="" id="status" v-model="store.status" class="form-control">
                           <option value="1">Active</option>
                           <option value="0">Decative</option>
                        </select>
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Roles:</b></label>
                        <select name="" id="role1" class="form-control" v-model="store.role">
                           <option disabled>Select Role</option>
                           <option v-for="(admin,index) in adminRole" :key="index" :value="admin.id">{{admin.name}}</option>
                        </select>
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
                  <h5 class="modal-title" id="exampleModalLabel">User Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Username:</b></label>
                        <p>{{show.name}}</p>   
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Email:</b></label>
                        <p>{{show.email}}</p>   
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Phone:</b></label>
                        <p>{{show.phone}}</p>   
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Status:</b></label>
                        <p>{{show.status}}</p>   
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Role:</b></label>
                        <p>
                           <span v-for="(role,index_2) in show.roles" :key="index_2">{{index_2+1}}.{{role.name}}</span>
                        </p>   
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
                  <h5 class="modal-title" id="exampleModalLabel">Edit User Details<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
            <form action="" method="Post" @submit.prevent="updateUser(show)">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <label for=""><b>Username:</b></label>
                        <input type="text" v-model="show.name" id="name" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Email:</b></label>
                        <input type="text" v-model="show.email" id="email" class="form-control" disabled>
                     </div>
                     <div class="col-md-12">
                        <label for=""><b>Password:</b></label>
                        <input type="text" v-model="show.password" id="pass" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Phone:</b></label>
                        <input type="text" v-model="show.phone" id="phone" class="form-control">
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Status:</b></label>
                        <select name="" id="status" v-model="show.status" class="form-control">
                           <option value="1">Active</option>
                           <option value="0">Decative</option>
                        </select>
                     </div>

                     <div class="col-md-12">
                        <label for=""><b>Roles:</b></label>
                        <select name="" id="" class="form-control" v-model="show.role">
                           <option disabled>Select Role</option>
                           <option v-for="(admin,index) in adminRole" :key="index" :value="admin.id">{{admin.name}}</option>
                        </select>
                     </div>
                     {{show.role}}
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

const INDEX_URL="/api/admin/user/index";
const STORE_URL="/api/admin/user/store";
const UPDATE_URL="/api/admin/user/update";
export default {
    mixins: [mixin],
   
    data(){
        return{
            columns:[
            {label: 'SL', name: '' },
            {label: 'Name', name: 'name' },
            {label: 'Email', name: 'email'},
            {label: 'Phone', name: 'phone'},
            {label: 'Status', name: 'status'},
            {label: 'Role', name: 'role'},
        ],
        adminRole:[],
        show:[],
        store:{
           name:'',
           email:'',
           phone:'',
           password:'',
           role:'',
           status:'',
        },

        accessControl:{
            edit:'',
            delete:'',
            create:''
    },
        }
    },
    methods: {
      getUSerData() {
        this.getData(INDEX_URL);
      },
      updateUser(data) {
        this.updateData(UPDATE_URL,data);
      },

      createUser(store) {
        this.store.name=store.name;
        this.store.email=store.email;
        this.store.phone=store.phone;
        this.store.password=store.password;
        this.store.role=store.role;
        this.store.status=store.status;
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
        this.getUSerData()
    },
    computed:{
       
    }
 
}
</script>


<style scoped>
td li{
   list-style :none;
}

li{
   list-style: none;
}
</style>
